# State Sharing

State sharing lets you set a resource state once and have it automatically applied to all subsequent resources using the same state—ideal for keeping nested or related resources in sync without repeating state declarations.

## Enabling Shared State

By default, state sharing is enabled. To disable it or change the default, update your `config/stateful-resources.php`:

```php
'shared_state' => true,
```

::: info
Disable shared state when you prefer to assign states explicitly on each resource.
:::

## Setting a Shared State

When you set a state on a resource, all further resources will inherit that state unless you override it:

```php
UserResource::state(State::Minimal)->make($user);
InvoiceResource::make($invoice); // Also in the Minimal state
SubscriptionResource::state(State::Full)->make($subscription); // Overrides to Full
```

## Nested Resources Example

In nested resources, the shared state will be used automatically:

```php
class UserResource extends StatefulJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'alias' => $this->whenStateFull($this->alias),
            'invoices' => $this->whenStateFull(InvoiceResource::collection($this->invoices)), // InvoiceResource automatically has the same state as UserResource
        ];
    }
}
```

## ActiveState Facade
You may also set the shared state explicitly through the `ActiveState` facade instead:

```php
use Farbcode\StatefulResources\Facades\ActiveState;

ActiveState::setShared('minimal');
```
