<div class="flex-center position-ref full-height">
    <div class="content">
        <h1 class="title m-b-md">
            Order List
        </div>

        @foreach($quotes as $quote)
            <div>
                {{ $quote->id }} - {{ $quote->quote }} - {{ $quote->karma }} - {{ $quote->posted_when }}
            </div>
        @endforeach
    </div>
</div>