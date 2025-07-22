<?php

namespace Farbcode\StatefulResources\Contracts;

/**
 * Interface for resource state enums that must be backed by string values.
 *
 * @template T of string
 */
interface ResourceState extends \BackedEnum {}
