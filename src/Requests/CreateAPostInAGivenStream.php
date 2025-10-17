<?php

namespace CodebarAg\LaravelBeekeeper\Requests;

use CodebarAg\LaravelBeekeeper\Data\Streams\Post;
use CodebarAg\LaravelBeekeeper\Responses\CreateAPostInAGivenStreamResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateAPostInAGivenStream extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $streamId,
        protected readonly string $text,
        protected readonly ?string $title = null,
        protected null|array|Collection $labels = null,
        protected readonly bool $sticky = false,
        protected readonly bool $locked = false,
        protected readonly bool $reactionsDisabled = false,
        protected readonly ?string $scheduledAt = null,
        protected null|array|Collection $files = null,
        protected null|array|Collection $photos = null,
        protected null|array|Collection $videos = null,
        protected null|array|Collection $media = null,
        protected null|array|Collection $options = null,
        protected readonly array|Collection $expand = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/streams/'.$this->streamId.'/posts';
    }

    protected function defaultQuery(): array
    {
        $expand = $this->expand;

        if ($expand instanceof Collection) {
            $expand = $expand->toArray();
        }

        return [
            'expand' => implode(',', $expand),
        ];
    }

    public function defaultBody(): array
    {
        $body = [
            'text' => $this->text,
        ];

        if (! empty($this->title)) {
            $body = Arr::add(array: $body, key: 'title', value: $this->title);
        }

        $labels = $this->labels;

        if ($labels instanceof Collection) {
            $labels = $labels->toArray();
        }

        if (! empty($labels)) {
            $body = Arr::add(array: $body, key: 'labels', value: $labels);
        }

        if ($this->sticky) {
            $body = Arr::add(array: $body, key: 'sticky', value: $this->sticky);
        }

        if ($this->locked) {
            $body = Arr::add(array: $body, key: 'locked', value: $this->locked);
        }

        if ($this->reactionsDisabled) {
            $body = Arr::add(array: $body, key: 'reactions_disabled', value: $this->reactionsDisabled);
        }

        if (! empty($this->scheduledAt)) {
            $body = Arr::add(array: $body, key: 'scheduled_at', value: $this->scheduledAt);
        }

        $files = $this->files;

        if ($files instanceof Collection) {
            $files = $files->toArray();
        }

        if (! empty($files)) {
            $body = Arr::add(array: $body, key: 'files', value: $files);
        }

        $photos = $this->photos;

        if ($photos instanceof Collection) {
            $photos = $photos->toArray();
        }

        if (! empty($photos)) {
            $body = Arr::add(array: $body, key: 'photos', value: $photos);
        }

        $videos = $this->videos;

        if ($videos instanceof Collection) {
            $videos = $videos->toArray();
        }

        if (! empty($videos)) {
            $body = Arr::add(array: $body, key: 'videos', value: $videos);
        }

        $media = $this->media;

        if ($media instanceof Collection) {
            $media = $media->toArray();
        }

        if (! empty($media)) {
            $body = Arr::add(array: $body, key: 'media', value: $media);
        }

        $options = $this->options;

        if ($options instanceof Collection) {
            $options = $options->toArray();
        }

        if (! empty($options)) {
            $body = Arr::add(array: $body, key: 'options', value: $options);
        }

        return $body;
    }

    public function createDtoFromResponse(Response $response): Post
    {
        return CreateAPostInAGivenStreamResponse::fromResponse($response);
    }
}
