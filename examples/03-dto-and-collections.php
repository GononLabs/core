<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Gonon\Core\Collections\AbstractCollection;
use Gonon\Core\DTO\AbstractData;

// 1. Define a concrete DTO
final readonly class UserData extends AbstractData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}

// 2. Define a concrete Collection
/**
 * @extends AbstractCollection<int, UserData>
 */
final readonly class UserCollection extends AbstractCollection {}

// 3. Usage
$user1 = UserData::fromArray(['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com']);
$user2 = UserData::fromArray(['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com']);

$collection = new UserCollection([$user1, $user2]);

echo 'Total Users: '.$collection->count().PHP_EOL;
echo 'First User Name: '.$collection->first()->name.PHP_EOL;

// Filter the collection (returns a new immutable collection instance)
$bobs = $collection->filter(fn (UserData $user) => $user->name === 'Bob');
echo 'Found Bobs: '.$bobs->count().PHP_EOL;

// Encode collection directly to JSON
echo 'JSON: '.json_encode($collection->toArray()).PHP_EOL;
