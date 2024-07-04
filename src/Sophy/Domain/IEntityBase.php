<?php

namespace Sophy\Domain;

interface IEntityBase {
    public function save();

    public function delete();
}
