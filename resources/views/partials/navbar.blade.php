<!-- =========================================================
     NAVIGATION (DYNAMIC FROM DATABASE)
========================================================= -->
<div class="category-navbar">
    <div class="container">
        <nav class="category-navigation">
            <a href="{{ route('products.index') }}" class="{{ !request('category') && request()->routeIs('products.index') ? 'active' : '' }}">
                ALL PRODUCTS
            </a>
            @if(isset($navCategories) && $navCategories->isNotEmpty())
                @foreach ($navCategories as $navCat)
                    <a href="{{ route('products.index', ['category' => $navCat->slug]) }}" class="{{ request('category') === $navCat->slug ? 'active' : '' }}">
                        {{ strtoupper($navCat->name) }}
                    </a>
                @endforeach
            @endif
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                CONTACT
            </a>
        </nav>
    </div>
</div>
