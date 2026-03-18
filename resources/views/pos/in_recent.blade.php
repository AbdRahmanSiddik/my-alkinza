<div class="modal fade pos-modal" id="recents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recent Transactions</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tabs-sets">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="purchase-tab" data-bs-toggle="tab"
                                data-bs-target="#purchase" type="button" aria-controls="purchase"
                                aria-selected="true" role="tab">Purchase</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payment-tab" data-bs-toggle="tab"
                                data-bs-target="#payment" type="button" aria-controls="payment"
                                aria-selected="false" role="tab">Payment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="return-tab" data-bs-toggle="tab"
                                data-bs-target="#return" type="button" aria-controls="return"
                                aria-selected="false" role="tab">Return</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="purchase" role="tabpanel"
                            aria-labelledby="purchase-tab">
                            <div class="card mb-0">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <span class="btn-searchset"><i
                                                    class="ti ti-search fs-14 feather-search"></i></span>
                                        </div>
                                    </div>
                                    <ul class="table-top-head">
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Pdf"><img
                                                    src="{{ asset('pos') }}/img/icons/pdf.svg"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Excel"><img
                                                    src="{{ asset('pos') }}/img/icons/excel.svg"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Print"><i class="ti ti-printer"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table datatable border">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="no-sort">
                                                        <label class="checkboxs">
                                                            <input type="checkbox" class="select-all">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </th>
                                                    <th>Customer</th>
                                                    <th>Reference</th>
                                                    <th>Date</th>
                                                    <th>Amount </th>
                                                    <th class="no-sort">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-27.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-27.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Carl Evans</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0101</td>
                                                    <td>24 Dec 2024</td>
                                                    <td>$1000</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-02.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-02.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Minerva Rameriz</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0102</td>
                                                    <td>10 Dec 2024</td>
                                                    <td>$1500</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-05.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-05.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Robert Lamon</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0103</td>
                                                    <td>27 Nov 2024</td>
                                                    <td>$1500</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-22.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-22.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Patricia Lewis</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0104</td>
                                                    <td>18 Nov 2024</td>
                                                    <td>$2000</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-03.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-03.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Mark Joslyn</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0105</td>
                                                    <td>06 Nov 2024</td>
                                                    <td>$800</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-12.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-12.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Marsha Betts</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0106</td>
                                                    <td>25 Oct 2024</td>
                                                    <td>$750</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-06.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-06.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Daniel Jude</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0107</td>
                                                    <td>14 Oct 2024</td>
                                                    <td>$1300</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment" role="tabpanel">
                            <div class="card mb-0">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <span class="btn-searchset"><i
                                                    class="ti ti-search fs-14 feather-search"></i></span>
                                        </div>
                                    </div>
                                    <ul class="table-top-head">
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Pdf"><img
                                                    src="{{ asset('pos') }}/img/icons/pdf.svg"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Excel"><img
                                                    src="{{ asset('pos') }}/img/icons/excel.svg"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Print"><i class="ti ti-printer"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table datatable border">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="no-sort">
                                                        <label class="checkboxs">
                                                            <input type="checkbox" class="select-all">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </th>
                                                    <th>Customer</th>
                                                    <th>Reference</th>
                                                    <th>Date</th>
                                                    <th>Amount </th>
                                                    <th class="no-sort">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-27.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-27.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Carl Evans</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0101</td>
                                                    <td>24 Dec 2024</td>
                                                    <td>$1000</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-02.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-02.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Minerva Rameriz</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0102</td>
                                                    <td>10 Dec 2024</td>
                                                    <td>$1500</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-05.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-05.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Robert Lamon</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0103</td>
                                                    <td>27 Nov 2024</td>
                                                    <td>$1500</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-22.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-22.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Patricia Lewis</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0104</td>
                                                    <td>18 Nov 2024</td>
                                                    <td>$2000</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-03.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-03.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Mark Joslyn</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0105</td>
                                                    <td>06 Nov 2024</td>
                                                    <td>$800</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-12.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-12.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Marsha Betts</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0106</td>
                                                    <td>25 Oct 2024</td>
                                                    <td>$750</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-06.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-06.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Daniel Jude</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0107</td>
                                                    <td>14 Oct 2024</td>
                                                    <td>$1300</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="return" role="tabpanel">
                            <div class="card mb-0">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <span class="btn-searchset"><i
                                                    class="ti ti-search fs-14 feather-search"></i></span>
                                        </div>
                                    </div>
                                    <ul class="table-top-head">
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Pdf"><img
                                                    src="{{ asset('pos') }}/img/icons/pdf.svg"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Excel"><img
                                                    src="{{ asset('pos') }}/img/icons/excel.svg"
                                                    alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Print"><i class="ti ti-printer"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table datatable border">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="no-sort">
                                                        <label class="checkboxs">
                                                            <input type="checkbox" class="select-all">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </th>
                                                    <th>Customer</th>
                                                    <th>Reference</th>
                                                    <th>Date</th>
                                                    <th>Amount </th>
                                                    <th class="no-sort">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-27.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-27.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Carl Evans</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0101</td>
                                                    <td>24 Dec 2024</td>
                                                    <td>$1000</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-02.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-02.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Minerva Rameriz</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0102</td>
                                                    <td>10 Dec 2024</td>
                                                    <td>$1500</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-05.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-05.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Robert Lamon</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0103</td>
                                                    <td>27 Nov 2024</td>
                                                    <td>$1500</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-22.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-22.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Patricia Lewis</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0104</td>
                                                    <td>18 Nov 2024</td>
                                                    <td>$2000</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-03.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-03.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Mark Joslyn</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0105</td>
                                                    <td>06 Nov 2024</td>
                                                    <td>$800</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-12.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-12.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Marsha Betts</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0106</td>
                                                    <td>25 Oct 2024</td>
                                                    <td>$750</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="checkboxs">
                                                            <input type="checkbox">
                                                            <span class="checkmarks"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);"
                                                                class="avatar avatar-md me-2">
                                                                <img alt="product"
                                                                    data-cfsrc="{{ asset('pos') }}/img/users/user-06.jpg"
                                                                    style="display:none;visibility:hidden;"><noscript><img
                                                                        src="{{ asset('pos') }}/img/users/user-06.jpg"
                                                                        alt="product"></noscript>
                                                            </a>
                                                            <a href="javascript:void(0);">Daniel Jude</a>
                                                        </div>
                                                    </td>
                                                    <td>INV/SL0107</td>
                                                    <td>14 Oct 2024</td>
                                                    <td>$1300</td>
                                                    <td class="action-table-data">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 edit-icon p-2"
                                                                href="javascript:void(0);"><i data-feather="eye"
                                                                    class="feather-eye"></i></a>
                                                            <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                    data-feather="edit"
                                                                    class="feather-edit"></i></a>
                                                            <a class="p-2" href="javascript:void(0);"><i
                                                                    data-feather="trash-2"
                                                                    class="feather-trash-2"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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