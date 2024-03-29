@extends('template.layouts.app')

@section('title', 'Knowledge Base')

@section('header')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="life-buoy"></i></div>
                            Knowledge Base
                        </h1>
                        <div class="page-header-subtitle">What are you looking for? Our knowledge base is here to help.</div>
                    </div>
                </div>
                <div class="page-header-search mt-4">
                    <div class="input-group input-group-joined">
                        <input class="form-control" type="text" placeholder="Search..." aria-label="Search" autofocus />
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-xl px-4">
        <!-- Knowledge base article-->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <a class="btn btn-transparent-dark btn-icon" href="knowledge-base-category.html"><i
                        data-feather="arrow-left"></i></a>
                <div class="ms-3">
                    <h2 class="my-3">Knowledge base article example</h2>
                </div>
            </div>
            <div class="card-body">
                <p class="lead">Here's an example of what an article in your knowledge base will look like.</p>
                <p class="lead">You can use the paragraph element along with other typography elements and text tools to
                    create articles within your knowledge base. This is a great way to display support information to your
                    users.</p>
                <p class="lead">The knowledge base page examples are a great starting point for creating FAQ's,
                    documentation, and more. In this section, we're using the lead paragraph class to make the text a bit
                    larger so it's more legible since it's meant to be read in sentences.</p>
                <p class="lead mb-5">You can also use step-by-step examples in this section:</p>
                <h4>Step 1: Start the process</h4>
                <p class="lead mb-4">Here is some example text of a longer version of a first step. This format is great
                    when you need to explain things more, not just using a ordered list.</p>
                <h4>Step 2: Continue doing something</h4>
                <p class="lead mb-4">We're using built-in elements and text utilities to make this list more legible and
                    understandable. This is a great starting point for a step by step guide within your knowledge base
                    article.</p>
                <h4>Step 3: Finish the process</h4>
                <p class="lead mb-5">We've used spacing utilities, text utilities, and other components within this article
                    example. This is just an example layout of a few things you can do within an article page. Thanks for
                    reading!</p>
                <div class="alert alert-primary alert-icon mb-0" role="alert">
                    <div class="alert-icon-aside"><i data-feather="alert-triangle"></i></div>
                    <div class="alert-icon-content">
                        <h5 class="alert-heading">Article Alert</h5>
                        If there is something in your article that you really want to emphasize, use the alert component, or
                        our custom icon alert component like this one here!
                    </div>
                </div>
            </div>
        </div>
        <!-- Knowledge base rating-->
        <div class="text-center mt-5">
            <h4 class="mb-3">Was this page helpful?</h4>
            <div class="mb-3">
                <button class="btn btn-primary mx-2 px-3" role="button">
                    <i class="me-2" data-feather="thumbs-up"></i>
                    Yes
                </button>
                <button class="btn btn-primary mx-2 px-3" role="button">
                    <i class="me-2" data-feather="thumbs-down"></i>
                    No
                </button>
            </div>
            <div class="text-small text-muted"><em>29 people found this page helpful so far!</em></div>
        </div>
    </div>
@endsection
