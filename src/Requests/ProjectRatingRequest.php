<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class ProjectRatingRequest
{
    #[Assert\NotBlank, Assert\NotNull()]
    public int $projectId;

    #[Assert\Valid()]
    public array $ratings ;


}
