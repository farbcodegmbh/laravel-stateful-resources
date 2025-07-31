<?php

use Farbcode\StatefulResources\Concerns\StatefullyLoadsAttributes;
use Farbcode\StatefulResources\Enums\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;

/**
 * Test resource class that uses the StatefullyLoadsAttributes trait
 */
class TestStatefulResource extends JsonResource
{
    use StatefullyLoadsAttributes;

    private string $state;

    public function __construct($resource, string $state = 'default')
    {
        parent::__construct($resource);
        $this->state = $state;
    }

    protected function getState(): string
    {
        return $this->state;
    }

    public function toArray(Request $request): array
    {
        return ['id' => $this->id];
    }

    // Expose protected methods for testing
    public function testWhenState($state, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->whenState($state, $value, $default)
            : $this->whenState($state, $value);
    }

    public function testUnlessState($state, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->unlessState($state, $value, $default)
            : $this->unlessState($state, $value);
    }

    public function testWhenStateIn(array $states, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->whenStateIn($states, $value, $default)
            : $this->whenStateIn($states, $value);
    }

    public function testUnlessStateIn(array $states, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->unlessStateIn($states, $value, $default)
            : $this->unlessStateIn($states, $value);
    }

    public function testMergeWhenState($state, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->mergeWhenState($state, $value, $default)
            : $this->mergeWhenState($state, $value);
    }

    public function testMergeUnlessState($state, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->mergeUnlessState($state, $value, $default)
            : $this->mergeUnlessState($state, $value);
    }

    public function testMergeWhenStateIn(array $states, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->mergeWhenStateIn($states, $value, $default)
            : $this->mergeWhenStateIn($states, $value);
    }

    public function testMergeUnlessStateIn(array $states, $value, $default = null)
    {
        return func_num_args() === 3
            ? $this->mergeUnlessStateIn($states, $value, $default)
            : $this->mergeUnlessStateIn($states, $value);
    }
}

beforeEach(function () {
    $this->resource = new TestStatefulResource((object) ['id' => 1], 'full');
});

describe('whenState', function () {
    test('returns value when state matches', function () {
        $result = $this->resource->testWhenState('full', 'test_value');
        expect($result)->toBe('test_value');
    });

    test('returns MissingValue when state does not match', function () {
        $result = $this->resource->testWhenState('table', 'test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns default when state does not match and default is provided', function () {
        $result = $this->resource->testWhenState('table', 'test_value', 'default_value');
        expect($result)->toBe('default_value');
    });

    test('works with State enum', function () {
        $result = $this->resource->testWhenState(State::Full, 'test_value');
        expect($result)->toBe('test_value');
    });
});

describe('unlessState', function () {
    test('returns MissingValue when state matches', function () {
        $result = $this->resource->testUnlessState('full', 'test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns value when state does not match', function () {
        $result = $this->resource->testUnlessState('table', 'test_value');
        expect($result)->toBe('test_value');
    });

    test('returns default when state matches and default is provided', function () {
        $result = $this->resource->testUnlessState('full', 'test_value', 'default_value');
        expect($result)->toBe('default_value');
    });

    test('works with State enum', function () {
        $result = $this->resource->testUnlessState(State::Table, 'test_value');
        expect($result)->toBe('test_value');
    });
});

describe('whenStateIn', function () {
    test('returns value when current state is in the array', function () {
        $result = $this->resource->testWhenStateIn(['full', 'table'], 'test_value');
        expect($result)->toBe('test_value');
    });

    test('returns MissingValue when current state is not in the array', function () {
        $result = $this->resource->testWhenStateIn(['table', 'minimal'], 'test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns default when current state is not in array and default is provided', function () {
        $result = $this->resource->testWhenStateIn(['table', 'minimal'], 'test_value', 'default_value');
        expect($result)->toBe('default_value');
    });

    test('works with State enums in array', function () {
        $result = $this->resource->testWhenStateIn([State::Full, State::Table], 'test_value');
        expect($result)->toBe('test_value');
    });

    test('works with mixed string and enum states', function () {
        $result = $this->resource->testWhenStateIn([State::Table, 'full'], 'test_value');
        expect($result)->toBe('test_value');
    });
});

describe('unlessStateIn', function () {
    test('returns MissingValue when current state is in the array', function () {
        $result = $this->resource->testUnlessStateIn(['full', 'table'], 'test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns value when current state is not in the array', function () {
        $result = $this->resource->testUnlessStateIn(['table', 'minimal'], 'test_value');
        expect($result)->toBe('test_value');
    });

    test('returns default when current state is in array and default is provided', function () {
        $result = $this->resource->testUnlessStateIn(['full', 'table'], 'test_value', 'default_value');
        expect($result)->toBe('default_value');
    });

    test('works with State enums in array', function () {
        $result = $this->resource->testUnlessStateIn([State::Table, State::Minimal], 'test_value');
        expect($result)->toBe('test_value');
    });
});

describe('mergeWhenState', function () {
    test('returns MergeValue when state matches', function () {
        $result = $this->resource->testMergeWhenState('full', ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });

    test('returns MissingValue when state does not match', function () {
        $result = $this->resource->testMergeWhenState('table', ['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns default when state does not match and default is provided', function () {
        $result = $this->resource->testMergeWhenState('table', ['key' => 'value'], 'default_value');
        expect($result)->toBeInstanceOf(MergeValue::class);
        expect($result->data)->toBe('default_value');
    });

    test('works with State enum', function () {
        $result = $this->resource->testMergeWhenState(State::Full, ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });
});

describe('mergeUnlessState', function () {
    test('returns MissingValue when state matches', function () {
        $result = $this->resource->testMergeUnlessState('full', ['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns MergeValue when state does not match', function () {
        $result = $this->resource->testMergeUnlessState('table', ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });

    test('returns default when state matches and default is provided', function () {
        $result = $this->resource->testMergeUnlessState('full', ['key' => 'value'], 'default_value');
        expect($result)->toBeInstanceOf(MergeValue::class);
        expect($result->data)->toBe('default_value');
    });

    test('works with State enum', function () {
        $result = $this->resource->testMergeUnlessState(State::Table, ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });
});

describe('mergeWhenStateIn', function () {
    test('returns MergeValue when current state is in the array', function () {
        $result = $this->resource->testMergeWhenStateIn(['full', 'table'], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });

    test('returns MissingValue when current state is not in the array', function () {
        $result = $this->resource->testMergeWhenStateIn(['table', 'minimal'], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns default when current state is not in array and default is provided', function () {
        $result = $this->resource->testMergeWhenStateIn(['table', 'minimal'], ['key' => 'value'], 'default_value');
        expect($result)->toBeInstanceOf(MergeValue::class);
        expect($result->data)->toBe('default_value');
    });

    test('works with State enums in array', function () {
        $result = $this->resource->testMergeWhenStateIn([State::Full, State::Table], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });

    test('works with mixed string and enum states', function () {
        $result = $this->resource->testMergeWhenStateIn([State::Table, 'full'], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });
});

describe('mergeUnlessStateIn', function () {
    test('returns MissingValue when current state is in the array', function () {
        $result = $this->resource->testMergeUnlessStateIn(['full', 'table'], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('returns MergeValue when current state is not in the array', function () {
        $result = $this->resource->testMergeUnlessStateIn(['table', 'minimal'], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });

    test('returns default when current state is in array and default is provided', function () {
        $result = $this->resource->testMergeUnlessStateIn(['full', 'table'], ['key' => 'value'], 'default_value');
        expect($result)->toBeInstanceOf(MergeValue::class);
        expect($result->data)->toBe('default_value');
    });

    test('works with State enums in array', function () {
        $result = $this->resource->testMergeUnlessStateIn([State::Table, State::Minimal], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });
});

describe('magic method support', function () {
    test('whenState magic methods work correctly', function () {
        $result = $this->resource->whenStateFull('test_value');
        expect($result)->toBe('test_value');

        $result = $this->resource->whenStateTable('test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('unlessState magic methods work correctly', function () {
        $result = $this->resource->unlessStateFull('test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);

        $result = $this->resource->unlessStateTable('test_value');
        expect($result)->toBe('test_value');
    });

    test('mergeWhenState magic methods work correctly', function () {
        $result = $this->resource->mergeWhenStateFull(['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);

        $result = $this->resource->mergeWhenStateTable(['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('mergeUnlessState magic methods work correctly', function () {
        $result = $this->resource->mergeUnlessStateFull(['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);

        $result = $this->resource->mergeUnlessStateTable(['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });
});

describe('edge cases', function () {
    test('empty state array in whenStateIn returns MissingValue', function () {
        $result = $this->resource->testWhenStateIn([], 'test_value');
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('empty state array in unlessStateIn returns value', function () {
        $result = $this->resource->testUnlessStateIn([], 'test_value');
        expect($result)->toBe('test_value');
    });

    test('empty state array in mergeWhenStateIn returns MissingValue', function () {
        $result = $this->resource->testMergeWhenStateIn([], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MissingValue::class);
    });

    test('empty state array in mergeUnlessStateIn returns MergeValue', function () {
        $result = $this->resource->testMergeUnlessStateIn([], ['key' => 'value']);
        expect($result)->toBeInstanceOf(MergeValue::class);
    });

    test('null values are handled correctly', function () {
        $result = $this->resource->testWhenState('full', null);
        expect($result)->toBeNull();
    });

    test('false values are handled correctly', function () {
        $result = $this->resource->testWhenState('full', false);
        expect($result)->toBeFalse();
    });

    test('zero values are handled correctly', function () {
        $result = $this->resource->testWhenState('full', 0);
        expect($result)->toBe(0);
    });
});
