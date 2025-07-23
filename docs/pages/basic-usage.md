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
            'profile' => $this->whenStateIn([State::Full], [
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

## Available Conditional Methods

The package provides several methods to conditionally include attributes:

### `whenState`

Include a value only when the current state matches the specified state:

```php
'email' => $this->whenState(State::Full, $this->email),
'admin_notes' => $this->whenState(State::Full, $this->admin_notes, 'N/A'),
```

### `unlessState`

Include a value unless the current state matches the specified state:

```php
'public_info' => $this->unlessState(State::Minimal, $this->public_information),
```

### `whenStateIn`

Include a value when the current state is one of the specified states:

```php
'detailed_info' => $this->whenStateIn([State::Full, State::Table], [
    'department' => $this->department,
    'position' => $this->position,
]),
```

### `unlessStateIn`

Include a value unless the current state is one of the specified states:

```php
'sensitive_data' => $this->unlessStateIn([State::Minimal, State::Table], $this->sensitive_info),
```

### Magic Conditionals

You can also use magic methods with for cleaner syntax:

```php
'email' => $this->whenStateFull($this->email),
'name' => $this->unlessStateMinimal($this->full_name),
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
