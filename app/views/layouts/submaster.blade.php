@extends("layouts.master")


@section("css")
@append

@section("body")
	@yield("left-nav")

	<div class="right-content">
		@yield("right-content")
	</div>
@append

@section("js")

@append