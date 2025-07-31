# Available Conditional Methods

The package provides several methods to conditionally include attributes in Stateful Resources.

[[toc]]

### `whenState`

Include a value only when the current state matches the specified state:

> 🪄 Magic method available

```php
'email' => $this->whenState(State::Full, $this->email),
// or
'email' => $this->whenStateFull($this->email),
```

### `unlessState`

Include a value unless the current state matches the specified state:

> 🪄 Magic method available

```php
'public_info' => $this->unlessState(State::Minimal, $this->public_information),
// or
'public_info' => $this->unlessStateMinimal($this->public_information),
```

### `whenStateIn`

Include a value when the current state is one of the specified states:

> No magic method available

```php
'detailed_info' => $this->whenStateIn([State::Full, State::Table], [
    'department' => $this->department,
    'position' => $this->position,
]),
```

### `unlessStateIn`

Include a value unless the current state is one of the specified states:

> No magic method available

```php
'sensitive_data' => $this->unlessStateIn([State::Minimal, State::Table], $this->sensitive_info),
```

### `mergeWhenState`

Merge an array of attributes when the current state matches the specified state:

> 🪄 Magic method available

```php
$attributes = $this->mergeWhenState(State::Full, [
    'email' => $this->email,
    'phone' => $this->phone,
]);
// or
$attributes = $this->mergeWhenStateFull([
    'email' => $this->email,
    'phone' => $this->phone,
]);
```

### `mergeUnlessState`
Merge an array of attributes unless the current state matches the specified state:

> 🪄 Magic method available

```php
$attributes = $this->mergeUnlessState(State::Minimal, [
    'email' => $this->email,
    'phone' => $this->phone,
]);
// or
$attributes = $this->mergeUnlessStateMinimal([
    'email' => $this->email,
    'phone' => $this->phone,
]);
```

### `mergeWhenStateIn`
Merge an array of attributes when the current state is one of the specified states:

> No magic method available

```php
$attributes = $this->mergeWhenStateIn([State::Full, State::Table], [
    'email' => $this->email,
    'phone' => $this->phone,
]);
```
### `mergeUnlessStateIn`
Merge an array of attributes unless the current state is one of the specified states:

> No magic method available

```php
$attributes = $this->mergeUnlessStateIn([State::Minimal, State::Table], [
    'email' => $this->email,
    'phone' => $this->phone,
]);
```