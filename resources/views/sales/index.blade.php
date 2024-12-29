@extends("layouts.app")
@section("wrapper")
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Search Input -->
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="search-bar-sm">
                        <input type="text" id="search-input" class="form-control search-input" placeholder="Search products by name, code or barcode">
                        <i class="bx bx-search search-icon"></i>
                    </div>
                    <div class="customer-sm">
                        <select name="customer_id" id="customer_id">
                            <option value="" disabled selected>Select the customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Main Content -->
            <div class="row row-gap-sm">
                <div class="col-md-6 sales-filter-sm">
                    <div class="sales-tab">
                        <!-- Category Filter -->
                        <ul id="category-filter">
                            <li class="sales-tab-item active" data-cat="all">All</li>
                            @foreach($categories as $category)
                            <li class="sales-tab-item" data-cat="{{ $category->id }}">{{ $category->title }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Product List -->
                    <div class="table-responsive  table-sm-2">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                </tr>
                            </thead>
                            <tbody id="product-list">
                                @if ($products->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No items are found!
                                    </td>
                                </tr>
                                @else
                                @foreach ($products as $product)
                                <tr data-category="{{ $product->category_id }}">
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>{{ $product->name }}</span>
                                            <div class="plus-sm add-product"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ $product->price }}"
                                                data-image="{{ $product->image }}">
                                                <i class="bx bx-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Selected Products Section -->
                <div class="col-md-6 position-relative col-sm-3">
                    <div id="selected-products" style="max-height: 345px; overflow-y: auto;"></div>
                    <div class="footer-section">
                        <div class="footer-cat">
                            <div id="payment-mode-section" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="payment-mode">Payment Mode:</label>
                                    <select id="payment-mode" class="form-control">
                                        <option value="">Select Payment Modes</option>
                                        <option value="esewa">eSewa</option>
                                        <option value="khalti">Khalti</option>
                                        <option value="bank">Bank</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn-confirm">Confirm</button>
                        </div>
                        <div class="price-cat">
                            <div class="price-sm-cat">
                                <span class="total-sm">Total Amount</span>
                                <span class="order-total">Rs. 0.00</span>
                            </div>
                            <div class="label-amt">
                                <label for="">Received Amount:</label>
                                <input type="number" class="amount-cal">
                            </div>
                            <div class="label-amt">
                                <label for="">Changes Amount: </label>
                                <input type="number" class="amount-cal" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@include('scripts.sales')
@endsection