<main class="content-wrapper">
    <h3 trn="customers">Customers</h3>
    <p class="mb-4" trn="customers-instruct">You can get information on your registered users here. Tap each row to send a mail to your customers </p>
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-0">
            <div class="table-responsive">
                <table class="table table-hoverable dashboard-table">
                    <tr>
                        <div class="pt-3 pl-2 pb-3 row d-flex col-12 justify-content-between">
                            <div class="col-6">
                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon search-text-field d-none d-md-flex ml-3 ">
                                    <i class="material-icons mdc-text-field__icon">search</i>
                                    <input class="mdc-text-field__input" id="text-field-hero-input">
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label for="text-field-hero-input" class="mdc-floating-label" trn="search">Search..</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <span>Sort by :</span>
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">New Customer</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" trn="old-customer">Old Customer</a>
                                    <a class="dropdown-item" href="#" trn="total-order">Total Order</a>
                                    <a class="dropdown-item" href="#" trn="name">Name</a>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <thead>
                        <tr style="background: #EFF3F3;">

                            <th class="text-left" trn="name">Name</th>
                            <th trn="email">Email</th>
                            <th trn="phone">Phone</th>
                            <th trn="total-order">Total Order</th>
                            <th trn="date-joined">Date Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($this->customers); $i++) {
                            $user = $this->customers[$i];
                            $orders = 0;
                        ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="mr-2" /><?php echo $user->getName(); ?>
                                </td>
                                <td><?php echo $user->getEmail(); ?></td>
                                <td> <?php echo $user->getPhoneNumber(); ?></td>
                                <td>
                                    <?php echo $orders; ?>
                                </td>
                                <td>
                                    <?php echo date("m-d-Y", $user->getTimeCreated()); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <span class="tx-14 pt-2" trn="paging-footer"> Showing: 1 - 10 of 1000 Customers</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <nav class="mx-auto">
                                    <ul class="pagination text-danger">
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">2 <span class="sr-only">(current)</span></a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row col-12 justify-content-center mt-5">
        <p trn="click-customer">Click on a customer row to send an email to them</p>
    </div>
</main>