<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class User extends Data
{
    public function __construct(
        public int|null    $id = null,
        public string|null $first_name = null,
        public string|null $last_name = null,
        public string|null $name = null,
        #[Email]
        public string|null $email = null,
        public string|null $phone = null,
        public string|null $gender = null,
        public string|null $link = null,
    )
    {
    }
}
