<?php

namespace Tests\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VideosTest extends TestCase
{
    use RefreshDatabase;
    /**@test*/
    public function test_example(): void
    {
        $video = Video::factory() ->create();

        $response = $this->getJson(route('api.videos.show',$video));

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'type' => 'video',
                    'id' => (string) $video->id,

                    'attributes' => [
                        'title' => $video->title,
                        'description' => $video->description,
                        'slug' => $video->slug,
                        'created_at' => $video->created_at->toJSON(),
                    'updated_at' => $video->updated_at->toJSON() ,
                    ],
                    'links' => [
                        'self' => route('api.videos.show',$video)
                    ]
                 ]
            ]);
    }



    public function index_test(){
        $this->withoutExceptionHandling();
        $videos = Video::factory()->count(3)->create();
        $response = $this->getJson(route('api.videos.index'));
    
        $videosJson = [];
    
        foreach ($videos as $video) {
            $video = $video->fresh();
            $videosJson[] = [
                'type' => 'video',
                'id' => (string) $video->id,
                'attributes' => [
                    'title' => $video->title,
                    'description' => $video->description,
                    'slug' => $video->slug,
                    'created_at' => $video->created_at->toJSON(),
                    'updated_at' => $video->updated_at->toJSON()
                ],
                'links' => [
                    'self' => route('api.videos.show', $video),
                ]
            ];
        }
        
    
        $response->assertExactJson([
            'data' => $videosJson,
            'links' => [
                'self' => route('api.videos.index')
            ]
        ]);
    }
    
}
