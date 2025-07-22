# Extending States

You may find yourself being too limited with the three Variant states included in the package's `Variant` enum.
This package allows you to register custom states that you can then use in your resources.

## Registering Custom States

Before using a custom state, register it in the package's `stateful-resources.states` configuration:

```php
<?php

return [
    'states' => [
        ...Variant::cases(), // The built-in states
        'custom', // Your custom state as a string
        ...CustomResourceState::cases(), // Or as cases of a custom enum
    ],
];
```

## Creating a Custom State Enum

Instead of using strings, you may want to create your own state enum to define custom states. This enum should implement the `ResourceState` interface provided by the package.

```php
<?php

namespace App\Enums;

use Farbcode\StatefulResources\Contracts\ResourceState;

enum CustomResourceState: string implements ResourceState
{
    case Compact = 'compact';
    case Extended = 'extended';
    case Debug = 'debug';
}
```

## Using Custom States

Now that you have created and registered your custom state enum, you can use it just like the built-in states inside your resources.

```php
<?php

namespace App\Http\Resources;

use Farbcode\StatefulResources\StatefulJsonResource;
use App\Enums\CustomResourceState;

class UserResource extends StatefulJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->whenState(CustomResourceState::Extended, $this->email),
            'debug_info' => $this->whenStateDebug([
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]),
            'avatar' => $this->unlessState('custom', $this->avatar),
        ];
    }
}
```

You can then apply the custom states to your resource in the same way you would with the built-in states:

```php
// Using the static method
UserResource::state(CustomResourceState::Compact)->make($user);

// Using the magic method (if the state name matches the case name)
UserResource::compact()->make($user);
```
