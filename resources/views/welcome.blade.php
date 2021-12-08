<!doctype html>
<head>
    <title>Reconciliation Project</title>
    <meta charset="utf-8"/>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <br>
        <h5 class="header">Property System</h5>
        <div class="file_selector box shadow-lg p-3 mb-5 bg-white rounded border border-2 border-dark">
            <h4>Link or Delink Agents with Properties</h4>
            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                <br>
                <div class="row g-3">

                    <div class="form-group col-md-6">
                        <label class="select_file">Select Agent</label>
                        <select class="form-control form-control-lg" id="agent" name="agent" required>
                            <option disabled>Select Agent</option>
                        </select>
                        <div class="text-danger" id="agentIdError"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="select_file">Select Role</label>
                        <select class="form-control form-control-lg" id="role" name="role" required>
                            <option value="viewing">Viewing</option>
                            <option value="selling">Selling</option>
                        </select>
                        <div class="text-danger" id="roleError"></div>
                    </div>

                    <div id="properties">

                    </div>
                    <div class="text-danger" id="propertyIdError"></div>

                    <input type="hidden" value="{{url('/')}}" id="base_url" name="base_url">
                    <br>
                    <div class="form-group">
                        <button type="submit" id="submit_file" class="btn btn-outline-primary">
                            <b>Link Properties</b>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>