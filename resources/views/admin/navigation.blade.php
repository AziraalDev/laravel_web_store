<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false" v-pre>
        Products
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('admin.products.create') }}">
            Create product
        </a>
        <a class="dropdown-item" href="{{ route('admin.products.index') }}">
            All products
        </a>
    </div>
</li>

<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false" v-pre>
        Categories
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('admin.categories.create') }}">
            Create categories
        </a>
        <a class="dropdown-item" href="{{ route('admin.categories.index') }}">
            All categories
        </a>
    </div>
</li>
