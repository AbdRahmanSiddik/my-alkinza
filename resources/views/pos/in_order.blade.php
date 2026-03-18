<div class="modal fade pos-modal" id="orders" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Orders</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tabs-sets">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="onhold-tab" data-bs-toggle="tab"
                                data-bs-target="#onhold" type="button" aria-controls="onhold"
                                aria-selected="true" role="tab">Onhold</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="unpaid-tab" data-bs-toggle="tab"
                                data-bs-target="#unpaid" type="button" aria-controls="unpaid"
                                aria-selected="false" role="tab">Unpaid</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="paid-tab" data-bs-toggle="tab"
                                data-bs-target="#paid" type="button" aria-controls="paid"
                                aria-selected="false" role="tab">Paid</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="onhold" role="tabpanel"
                            aria-labelledby="onhold-tab">
                            <div class="input-icon-start pos-search position-relative mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search Product">
                            </div>
                            <div class="order-body">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <span class="badge bg-dark fs-12 mb-2">Order ID : #45698</span>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                        :</span> $900</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                    Botsford</p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                        :</span> 24 Dec 2024 13:39:11</p>
                                            </div>
                                        </div>
                                        <div class="bg-info-transparent p-1 rounded text-center my-3">
                                            <p class="text-info fw-medium">Customer need to recheck the product
                                                once</p>
                                        </div>
                                        <div
                                            class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                            <a href="javascript:void(0);" class="btn btn-md btn-orange">Open
                                                Order</a>
                                            <a href="javascript:void(0);" class="btn btn-md btn-teal"
                                                data-bs-dismiss="modal" data-bs-toggle="modal"
                                                data-bs-target="#products">View Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-md btn-indigo">Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-light mb-0">
                                    <div class="card-body">
                                        <span class="badge bg-dark fs-12 mb-2">Order ID : #666659</span>
                                        <div class="mb-3">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <p class="fs-15 mb-1"><span
                                                            class="fs-14 fw-bold text-gray-9">Cashier :</span>
                                                        admin</p>
                                                    <p class="fs-15"><span
                                                            class="fs-14 fw-bold text-gray-9">Total :</span> $900
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="fs-15 mb-1"><span
                                                            class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                        Botsford</p>
                                                    <p class="fs-15"><span
                                                            class="fs-14 fw-bold text-gray-9">Date :</span> 24 Dec
                                                        2024 13:39:11</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="unpaid" role="tabpanel">
                            <div class="input-icon-start pos-search position-relative mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search Product">
                            </div>
                            <div class="order-body">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <span class="badge bg-dark fs-12 mb-2">Order ID : #45698</span>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                        :</span> $900</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                    Anastasia</p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                        :</span> 24 Dec 2024 13:39:11</p>
                                            </div>
                                        </div>
                                        <div class="bg-info-transparent p-1 rounded text-center my-3">
                                            <p class="text-info fw-medium">Customer need to recheck the product
                                                once</p>
                                        </div>
                                        <div
                                            class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                            <a href="javascript:void(0);" class="btn btn-md btn-orange">Open
                                                Order</a>
                                            <a href="javascript:void(0);" class="btn btn-md btn-teal"
                                                data-bs-dismiss="modal" data-bs-toggle="modal"
                                                data-bs-target="#products">View Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-md btn-indigo">Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-light mb-0">
                                    <div class="card-body">
                                        <span class="badge bg-dark fs-12 mb-2">Order ID : #666659</span>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                        :</span> $900</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Customer :</span> Lucia
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                        :</span> 24 Dec 2024 13:39:11</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="paid" role="tabpanel">
                            <div class="input-icon-start pos-search position-relative mb-3">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search Product">
                            </div>
                            <div class="order-body">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <span class="badge bg-dark fs-12 mb-2">Order ID : #45698</span>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                        :</span> $1000</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Customer :</span> Hugo
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                        :</span> 24 Dec 2024 13:39:11</p>
                                            </div>
                                        </div>
                                        <div class="bg-info-transparent p-1 rounded text-center my-3">
                                            <p class="text-info fw-medium">Customer need to recheck the product
                                                once</p>
                                        </div>
                                        <div
                                            class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                                            <a href="javascript:void(0);" class="btn btn-md btn-orange">Open
                                                Order</a>
                                            <a href="javascript:void(0);" class="btn btn-md btn-teal"
                                                data-bs-dismiss="modal" data-bs-toggle="modal"
                                                data-bs-target="#products">View Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-md btn-indigo">Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card bg-light mb-0">
                                    <div class="card-body">
                                        <span class="badge bg-dark fs-12 mb-2">Order ID : #666659</span>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Cashier :</span> admin
                                                </p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Total
                                                        :</span> $9100</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="fs-15 mb-1"><span
                                                        class="fs-14 fw-bold text-gray-9">Customer :</span>
                                                    Antonio</p>
                                                <p class="fs-15"><span class="fs-14 fw-bold text-gray-9">Date
                                                        :</span> 23 Dec 2024 13:39:11</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>