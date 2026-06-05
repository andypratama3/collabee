<?php

namespace App\Enums;

enum ContentStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case UNDER_REVIEW = 'under_review';
    case REVISION_REQUESTED = 'revision_requested';
    case APPROVED = 'approved';
    case POSTED = 'posted';
    case REJECTED = 'rejected';
}
