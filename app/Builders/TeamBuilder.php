<?php

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeamBuilder extends Builder
{
    public function whereCreator(User $user): self
    {
        return $this->where('user_id', $user->id);
    }

    public function whereContains(string $searchTerm): self
    {
        return $this->where(function ($query) use ($searchTerm) {
            $query->where('title', 'LIKE', "%$searchTerm%")
                ->orWhere('body', 'LIKE', "%$searchTerm%");
        });
    }

    public function orderByRatings(): self
    {
        return $this->withAvg('ratings as avg_rating', 'rating')
            ->orderByDesc('avg_rating');
    }

    public function mostPopular(int $count = 1): self
    {
        return $this->orderByRatings()->take($count);
    }

    public function publishAll(): self
    {
        $this->whereNotPublished()->update(['published' => true]);

        return $this;
    }

    public function publish(): Model
    {
        $this->model->update(['published' => true]);

        return $this->model;
    }

    public function wherePublished(): self
    {
        return $this->where('published', true);
    }

    public function whereNotPublished(): self
    {
        return $this->where('published', false);
    }

    public function general(): self
    {
        return $this->where('type', 'general');
    }

    public function private(): self
    {
        return $this->where('type', 'private');
    }
}
