<x-layouts.backend>
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Main Title</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Examples</li>
                        <li class="breadcrumb-item active" aria-current="page">Blank</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Tests</h3>
            </div>
            <div class="block-content">
                <ol>
                @foreach ($tests as $test)
                    <li><a href="{{ route('backend.test',$test) }}">{{$test}}</a></li>
                @endforeach
                </ol>
            </div>
        </div>
        <!-- END Your Block -->
        <!-- Your Block -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Current Test Result</h3>
            </div>
            <div class="block-content">
                <p>{{ $message }}</p>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
</x-layouts.backend>
