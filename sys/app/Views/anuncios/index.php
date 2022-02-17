<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Anuncios</h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            This week
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="border rounded p-4 mb-4">
            <form class="row g-3 needs-validation" novalidate>
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">First name</label>
                    <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">Username</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                        <div class="invalid-feedback">
                            Please choose a username.
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom03" class="form-label">City</label>
                    <input type="text" class="form-control" id="validationCustom03" required>
                    <div class="invalid-feedback">
                        Please provide a valid city.
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">State</label>
                    <select class="form-select" id="validationCustom04" required>
                        <option selected disabled value="">Choose...</option>
                        <option>...</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid state.
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="validationCustom05" required>
                    <div class="invalid-feedback">
                        Please provide a valid zip.
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                        <label class="form-check-label" for="invalidCheck">
                            Agree to terms and conditions
                        </label>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Submit form</button>
                </div>
            </form>
    </div>

    <?php for ($i = 1; $i <= 15; $i++) : ?>
        <article>
            <div class="row">
                <div class="col-md-3">
                    <a href="#">
                        <img src="http://placehold.it/260x180" class="img-fluid">
                    </a>
                </div>
                <div class="col-md-9">
                    <p>
                        Lorem ipsum dolor sit amet, id nec conceptam conclusionemque. Et eam tation option. Utinam salutatus ex eum. Ne mea dicit tibique facilisi, ea mei omittam explicari conclusionemque, ad nobis propriae quaerendum sea.
                    </p>
                    <a class="btn btn-secondary" href="#">Read more</a>
                </div>
            </div>
            <div>

                <i class="icon-user"></i> by <a href="#">John</a>
                | <i class="icon-calendar"></i> Sept 16th, 2012
                | <i class="icon-comment"></i> <a href="#">3 Comments</a>
                | <i class="icon-share"></i> <a href="#">39 Shares</a>
                | <i class="icon-tags"></i> Tags : <a href="#"><span class="label label-info">Snipp</span></a>
                <a href="#"><span class="label label-info">Bootstrap</span></a>
                <a href="#"><span class="label label-info">UI</span></a>
                <a href="#"><span class="label label-info">growth</span></a>

            </div>
        </article>

        <hr>
    <?php endfor; ?>
</div>
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Indicaciones
        </div>
        <div class="card-body">
            Nam viverra tellus velit, eu cursus eros fermentum pellentes. Cras lacinia blandit justo ac volutpat. Vestibulum commodo diam nulla, sit amet hendrerit dui facilisis et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis nec nibh dapibus, fermentum vehicula e
        </div>
    </div>
</div>
</div>