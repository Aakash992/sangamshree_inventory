<script>
    $(document).ready(function() {
        let selectedProducts = [];

        // Category filtering
        $('#category-filter li').on('click', function() {
            const category = $(this).data('cat');
            $('#category-filter li').removeClass('active');
            $(this).addClass('active');

            if (category === 'all') {
                $('#product-list tr').show();
            } else {
                $('#product-list tr').each(function() {
                    if (($(this).data('category')) === (category)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });

        // Search functionality
        $('#search-input').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $("#product-list tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Add product to the selected products list
        $('#product-list').on('click', '.add-product', function() {
            const $this = $(this);
            const productId = $this.data('id');
            let existingProduct = selectedProducts.find(p => p.id === productId);

            if (existingProduct) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Already Exist!'
                });
            } else {
                selectedProducts.push({
                    id: productId,
                    name: $this.data('name'),
                    price: parseFloat($this.data('price')),
                    image: $this.data('image'),
                    quantity: 1
                });
                updateProductDisplay();
            }
        });

        function updateProductList(products) {
            let $productListContainer = $('#product-list');
            $productListContainer.empty();

            if (products.length === 0) {
                $productListContainer.append('<tr><td colspan="4" class="text-center">No items found</td></tr>');
            } else {
                products.forEach(function(product) {
                    let productRow = `
            <tr data-category="${product.category_id}">
                <td>
                    <div class="d-flex align-items-center justify-content-between">
                        <span>${product.name}</span>
                        <div class="plus-sm add-product"
                            data-id="${product.id}"
                            data-name="${product.name}"
                            data-price="${product.price}"
                            data-image="${product.image}">
                            <i class="bx bx-plus"></i>
                        </div>
                    </div>
                </td>
            </tr>`;
                    $productListContainer.append(productRow);
                });
            }
        }

        // Update product display
        function updateProductDisplay() {
            let $selectedProductsContainer = $('#selected-products');
            $selectedProductsContainer.empty();

            if (selectedProducts.length > 0) {
                selectedProducts.forEach(function(product, index) {
                    let productHtml = `
            <div class="card-sm-wrapper" data-index="${index}">
                <div class="product-drawer">  
                        <div class="product-item-sm">
                            <h5 class="card-title sm-name">${product.name}</h5>
                            <h6>Quantity</h6>
                            <div class="btn-qty">
                                <button class="decrease-quantity" data-index="${index}">-</button>
                                <span class="count">${product.quantity}</span>
                                <button class="increase-quantity" data-index="${index}">+</button>
                            </div>
                        </div>
                        <div class="price-sm">
                            <button class=" btn-sm-trash trash-button" data-index="${index}">
                                <i class="bx bx-trash"></i>
                            </button>
                            <span class="product-total">Rs.${(product.price * product.quantity).toFixed(2)}</span>
                        </div>
                </div>
            </div>`;
                    $selectedProductsContainer.append(productHtml);
                });

                $('#payment-mode-section').show();
            } else {
                $selectedProductsContainer.html('');
                $('#payment-mode-section').hide();
            }

            updateTotalAmount();
        }

        // Update total amount
        function updateTotalAmount() {
            let totalAmount = selectedProducts.reduce((total, product) => total + (product.price * product.quantity), 0);
            $('.order-total').text(`Rs. ${totalAmount.toFixed(2)}`);
            calculateChange();
        }

        // Calculate change amount
        $('.amount-cal').first().on('input', calculateChange);

        function calculateChange() {
            let totalAmount = parseFloat($('.order-total').text().replace('Rs. ', '')) || 0;
            let receivedAmount = parseFloat($('.amount-cal').first().val()) || 0;
            let changeAmount = Math.max(receivedAmount - totalAmount, 0);

            $('.amount-cal').last().val(changeAmount.toFixed(2));
        }

        // Increase/Decrease quantity
        $('#selected-products').on('click', '.increase-quantity', function() {
            const index = $(this).data('index');
            let product = selectedProducts[index];
            product.quantity++;
            updateProductDisplay();
        });

        $('#selected-products').on('click', '.decrease-quantity', function() {
            const index = $(this).data('index');
            let product = selectedProducts[index];
            if (product.quantity > 1) {
                product.quantity--;
                updateProductDisplay();
            }
        });

        // Remove product
        $('#selected-products').on('click', '.trash-button', function() {
            const index = $(this).data('index');
            selectedProducts.splice(index, 1);
            updateProductDisplay();
        });

        // Confirm button click handler
        $('.btn-confirm').on('click', function() {
            if (selectedProducts.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Select at least one product!'
                });
                return;
            }
            let paymentMode = $('#payment-mode').val();
            if (!paymentMode) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select a payment mode!'
                });
                return;
            }
            let totalAmount = parseFloat($('.order-total').text().replace('Rs. ', '')) || 0;
            let receivedAmount = parseFloat($('.amount-cal').first().val()) || 0;
            if (receivedAmount < totalAmount) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Select receive amount more than the total amount!'
                });
                return;
            }

            let salesData = {
                order_by: 'order_by',
                customer_id: null,
                products: selectedProducts.map(product => ({
                    product_id: product.id,
                    qty: product.quantity,
                    payment_mode: paymentMode
                })),
                _token: "{{csrf_token()}}"
            };

            $.ajax({
                url: "{{route('admin.sales.store')}}",
                method: 'POST',
                data: salesData,
                success: function(response) {
                    if (response.type === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                        selectedProducts = [];
                        updateProductDisplay();
                        $('#payment-mode').val('');
                        $('.amount-cal').val('');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing the request: ' + error
                    });
                }
            });
        });
    });
</script>