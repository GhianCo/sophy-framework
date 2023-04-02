<?php

namespace Sophy\Domain;

interface BaseRepository {
    public function save(BaseEntity $entity): BaseEntity;

    public function delete(BaseEntity $entity);

}
