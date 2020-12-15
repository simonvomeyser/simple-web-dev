<p align="center">
  <a href="https://simonvomeyser.de">
    <img alt="Screenshot of the blog frontpage" src="https://github.com/simonvomeyser/simple-web-dev/blob/master/screenshot.png?raw=true" />
  </a>
</p>

<h1 align="center">
My personal blog
</h1>

This blog is a small diary of the things I learn while on this intimidating journey through web development land.

I write about technical stuff but sprinkle in a few words about project management from time to time, all decorated with some very nerdy humor.

I developed the platform myself by using a Laravel installation, the posts are stored as markdown files and version controlled. I needed to do quite a few customizations with the Markdown parser, so I wrote <a href="https://simple-web.dev/extending-laravel-markdown-with-lazy-images" target="_blank" rel="noopener noreferrer">a post</a> about that.

## Installation
 
To install this page clone the repository first.
```bash
git clone git@github.com:simonvomeyser/simple-web-dev.git
```

Next, you need to install the dependencies.
```bash
composer install
npm install
```

Create your env
```bash
cp .env.example .env
php artisan key:generate
```

## Misc

The posts are generated from markdown files and can be cached for production via the command:

```bash
php artisan cache-posts
```
