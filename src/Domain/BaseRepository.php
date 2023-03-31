<?php

namespace Sophy\Domain;

interface BaseRepository {
    public function insert(BaseEntity $entity): int;

    public function update(BaseEntity $entity): void;

    public function delete(BaseEntity $entity);

    public function fetchRowByCriteria(array $criteria = []);

    public function fetchRowsByCriteria(array $criteria = []);
}
