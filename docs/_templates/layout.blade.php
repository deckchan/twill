<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{$title}}</title>
  <link href="/style.css" rel="stylesheet">
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>
@php
  $currentSegment = \Illuminate\Support\Str::before(ltrim($url, '/'), '/');
@endphp
<div class="flex flex-col h-screen overflow-hidden print:h-full" x-data="{open: false}">
  <nav class="bg-white shadow">
    <div class="mx-auto px-2 sm:px-6 lg:px-4">
      <div class="relative flex h-16 justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center md:hidden">
          <button
            x-on:click="open = !open"
            type="button"
            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
            aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="block h-6 w-6" x-bind:class="{hidden: open}" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
            <svg class="hidden h-6 w-6" x-bind:class="{hidden: !open}" xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        <div class="flex flex-1 items-center justify-center md:items-stretch md:justify-between">
          <div class="flex flex-shrink-0 items-center">
            <a href="/index.html">
              <img class="block h-8 w-auto lg:hidden" src="/assets/twill_logo.svg" alt="Twill">
              <img class="hidden h-8 w-auto lg:block" src="/assets/twill_logo.svg" alt="Twill">
            </a>
          </div>
          <div class="hidden md:ml-6 md:flex md:space-x-8 print:!hidden">
            @foreach($tree as $key => $item)
              @unless($key === '')
                <a href="{{$item['url']}}"
                   class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{$item['title']}}</a>
              @endunless
            @endforeach
          </div>
          <div class="hidden md:ml-6 md:flex md:space-x-8 print:!hidden">
            <div class="flex items-center">
              <a href="https://github.com/area17/twill" target="_blank"
                 class="bg-black text-white rounded-lg text-white m-4 px-2 py-2 text-baseline"
                 rel="noopener">
                GitHub
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="flex flex-1 overflow-hidden">
    @if (isset($tree[$currentSegment]))
      <div class="xl:w-72 overflow-x-hidden overflow-y-auto p-4 pt-8 md:block print:!hidden"
           x-transition
           x-bind:class="{hidden: !open}"
      >
        <nav class="text-base lg:text-sm w-64 pr-8 xl:w-72 xl:pr-16">
          <ul role="list" class="space-y-5">
            @foreach($tree as $key => $item)
              @unless($key === '')
                <li class="md:hidden"><a href="{{$item['url']}}"
                                         class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{$item['title']}}</a>
                </li>
              @endunless
            @endforeach

            <li>
              <a href="{{$tree[$currentSegment]['url'] ?? '#'}}">
                <h2 class="font-display font-medium text-slate-900 dark:text-white">
                  {{$tree[$currentSegment]['title'] ??''}}
                </h2></a>
              @if (!empty($tree[$currentSegment]['items'] ??[]))
                <ul class="mt-2 space-y-1 border-l-2 border-slate-100 lg:mt-2 lg:space-y-2 lg:border-slate-200">
                  @foreach($tree[$currentSegment]['items'] ?? [] as $item)
                    @php
                      $open = \Illuminate\Support\Str::betweenFirst(ltrim($item['url'], '/'), '/', '/') ===  \Illuminate\Support\Str::betweenFirst(ltrim($url, '/'), '/', '/');
                    @endphp
                    <li class="relative" x-data="{open: {{$open ? 'true' : 'false'}}}">
                      <div class="flex">
                        <a
                          class="inline pl-3.5 before:pointer-events-none before:absolute before:-left-1 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-y-1/2 before:rounded-full text-slate-500 before:hidden before:bg-slate-300 hover:text-slate-600 hover:before:block @if($open) text-black font-bold @endif"
                          href="{{$item['url'] ??'#' }}">{{$item['title'] ?? ''}}</a>
                        @if (!empty($item['items'] ??[]))
                          <div class="flex-1 cursor-pointer px-5 items-center flex"
                               x-on:click="open = !open">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 x-cloak
                                 stroke="currentColor" class="w-3 h-3" x-show="!open">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-3 h-3" x-show="open">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12h-15"/>
                            </svg>
                          </div>
                        @endif
                      </div>
                      @if (!empty($item['items'] ??[]))
                        <ul
                          class="@if ($open) block @else hidden @endif mt-2 ml-4 space-y-1 border-l-2 border-slate-100 lg:mt-4 lg:space-y-2 lg:border-slate-200"
                          x-bind:class="{'hidden': !open}"
                    @foreach($item['items'] ?? [] as $item)
                      @php
                        $active = $url === $item['url'];
                      @endphp
                      <li class="relative">
                        <a
                          class="block w-full pl-3.5 before:pointer-events-none before:absolute before:-left-1 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-y-1/2 before:rounded-full text-slate-500 before:hidden before:bg-slate-300 hover:text-slate-600 hover:before:block @if($active) text-black font-bold @endif"
                          href="{{$item['url'] ?? '#'}}">{{$item['title'] ?? ''}}</a>
                      </li>
                    @endforeach
                </ul>
              @endif
            </li>
            @endforeach
          </ul>
          @endif
          </li>
          </ul>
        </nav>
      </div>
    @endif
    <div class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto p-8">
      <div class="flex-1 flex flex-wrap h-full">
        <div class="flex flex-col h-full">
          <div class="max-w-4xl w-full prose prose-gray flex-1">
            {!! $content !!}
          </div>
          <div class="text-gray-400 text-xs pt-4">
            © 2020 Twill — Crafted by AREA 17 | Syntax highlighting by <a
              href="https://torchlight.dev">torchlight.dev</a>
          </div>
        </div>
        <div class="min-w-64 prose order-first xl:order-last print:hidden"
        >
          {!! $toc !!}
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>