<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Filters on Search Button Click</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Style for the details (hidden content) */
        #details {
            display: none;
            /* Additional styles for the hidden details */
            padding: 10px;
            border: 1px solid #ccc;
        }

        /* Show details when the checkbox is checked */
        #toggle-filters:checked + #details {
            display: block;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Term" aria-label="Search Term">
                    <input type="checkbox" class="btn-check" id="toggle-filters" autocomplete="off">
                    <label class="btn btn-primary" for="toggle-filters">Search</label>
                </div>
            </div>
        </div>

        <!-- Hidden details content -->
        <details id="details">
            <summary class="text-center btn btn-success fw-bold shadow-sm">Filtros avanzados</summary>
            <fieldset id="filtros">
                <div class="busqueda-filtros">
                    <div class="row filtros-pistas mt-4">
                        <!-- Your form fields go here -->
                        <div class="col-md-6">
                            <label for="filter1">Filter 1:</label>
                            <input type="text" class="form-control" id="filter1" placeholder="Filter 1">
                        </div>
                        <div class="col-md-6">
                            <label for="filter2">Filter 2:</label>
                            <input type="text" class="form-control" id="filter2" placeholder="Filter 2">
                        </div>
                        <!-- Add more filters as needed -->
                    </div>
                </div>
            </fieldset>
        </details>
    </div>

</body>
</html>
