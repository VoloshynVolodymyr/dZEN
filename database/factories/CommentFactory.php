<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        $imagePath = null;


        $user = User::inRandomOrder()->first();

        if ($this->faker->boolean) {
            $imageUrl = 'https://picsum.photos/640/480';
            $image = Image::make($imageUrl);
            $image->fit(320, 240);
            $imagePath = 'storage/images/' . md5(Carbon::now() . '_' . $this->faker->image) . '.jpg';
            $image->save(public_path($imagePath));
        }

        return [
            'user_id' => $user->id,
            'parent_id' => null,
            'text' => $this->faker->paragraph,
            'image' => $imagePath,
        ];
    }
}

