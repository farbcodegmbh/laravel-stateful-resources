# Basic Usage

Laravel Stateful Resources allows you to create dynamic API responses by changing the structure of your JSON resources based on different states. This is especially useful when you need to return different levels of detail for the same model depending on the context.

## Generating a Stateful Resource

The package provides an Artisan command to quickly generate a new stateful resource:

```bash
php artisan make:stateful-resource UserResource
```

This command creates a new resource class in `app/Http/Resources/` that extends `StatefulJsonResource`:

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Farbcode\StatefulResources\StatefulJsonResource;

class UserResource extends StatefulJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
```

## Built-in States

The package comes with three built-in states defined in the `State` enum:

-   **`Full`** - For all available attributes
-   **`Table`** - For attributes suitable for table/listing views
-   **`Minimal`** - For only essential attributes

See the [Extending States](extending-states.md) documentation for how to configure this and add custom states.

## Using States in Resources

Inside your stateful resource, you can use conditional methods to control which attributes are included based on the current state:

```php
<?php

namespace App\Http\Resources;

use Farbcode\StatefulResources\Enums\State;
use Farbcode\StatefulResources\StatefulJsonResource;
use Illuminate\Http\Request;

class UserResource extends StatefulJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->whenState(State::Full, $this->email),
            'profile' => $this->whenStateIn([State::Full], fn () => [
                'bio' => $this->bio,
                'avatar' => $this->avatar,
                'created_at' => $this->created_at,
            ]),
            'role' => $this->whenStateIn([State::Full, State::Table], $this->role),
            'last_login' => $this->unlessState(State::Minimal, $this->last_login_at),
        ];
    }
}
```

You can also use the string representation of states instead of enum cases:

```php
'email' => $this->whenState('full', $this->email),
'name' => $this->unlessState('minimal', $this->full_name),
```


### Magic Conditionals

You can also use magic methods with for cleaner syntax:

```php
'email' => $this->whenStateFull($this->email),
'name' => $this->unlessStateMinimal($this->full_name),
```

For a full list of available conditional methods, see the [Available Conditional Methods](reference/conditional-methods.md) reference.

### Performance Considerations

Please be aware that heavily relying on conditional methods can lead to performance implications depending on how they are utilized within your resources.

During the execution of `toArray`, all _directly accessed_ model attributes, model accessors and function calls **will be computed, no matter the current state of the given Stateful Resource**.

Here's an example of a Stateful Resource that may compute more than is needed when the state is `Minimal`:

```php
public function toArray(): array
{
    return [
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->unlessStateMinimal($this->address), // ⚠️ `$this->address` will always be computed although its value may not be used
    ];
}
```

The impact for smaller resources is _minimal_, as the overhead of computing unused attributes is negligible. However, for large resources with many attributes, this may lead to performance issues.

But there is a way to circumvent this issue by wrapping the attribute content in a closure:

```php
public function toArray(): array
{
    return [
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->unlessStateMinimal($this->address), // [!code --]
        'address' => $this->unlessStateMinimal(fn () => $this->address), // ✅ `$this->address` won't be computed unless the condition is met [!code ++]
    ];
}
```

### Manual State Access

If you need more complex logic than inline conditionals, you can access the resource's current state directly using the `getState()` method:

```php
if ($this->getState() === 'full') {
    // Do something specific for the full state
}
```

## Using Stateful Resources

### Setting the State Explicitly

Use the static `state()` method to create a resource with a specific state:

```php
$user = UserResource::state(State::Minimal)->make($user);
```

### Using Magic Methods

You can also use magic methods for a more fluent syntax:

```php
// This is equivalent to the explicit state(State::Minimal) call
$user = UserResource::minimal()->make($user);
```

### Default State

If no state is specified, the resource will use the default state. You can change the default state in the package's configuration file: `config/stateful-resources.php`.

```php
// Uses the default state
$user = UserResource::make($user);
```
