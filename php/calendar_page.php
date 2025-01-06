<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR.FREDDIE Shoe Repair - Appointment Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Book an Appointment</h1>

        <div class="calendar-navigation">
            <div class="row align-items-center">
                <div class="col">
                    <button class="">Previous Month</button>
                </div>
                <div class="col">
                    <h2 id="current-month"><?php echo date('F Y', mktime(0,0,0,$current_month,1,$current_year)); ?></h2>
                </div>
                <div class="col">
                    <button class="">Next Month</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>