<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <style>
        .btn-custom-purple {
            background-color: #145F9A;
            border-color: #145F9A;
            color: white;
        }

        .btn-custom-purple:hover {
            background-color: #145F9A;
            border-color: #145F9A;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em auto;
        }

        th,
        td {
            padding: 0.5em 1em;
            text-align: left;
        }

        thead {
            background-color: #145F9A;
            color: white;
            font-weight: bold;
            border-top-left-radius: 10px;

        }

        .tr-custom {
            border-top-left-radius: 10px;
        }

        tbody {
            border: 1px solid #ddd;
        }

        #locationTable td {
            text-align: center;
        }

        #locationTable th {
            text-align: center;
        }

        #loadingSave {
            display: none;
        }

        #loadingDelete {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            function fetchLocations() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/student/list') }}",
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                        let tableBody = $('#locationTable tbody');
                        tableBody.empty();
                        data.forEach(function(counter, index) {
                            tableBody.append(`
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${counter.name}</td>
                            <td class="text-center">${counter.surname}</td>
                            <td class="text-center">${counter.age}</td>
                            <td class="text-center">${counter.year}</td>
                            <td class="text-center">${counter.sex}</td>
                        </tr>
                    `);
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function saveStudentData() {
                console.log("Save");
                // Get form values
                const name = document.getElementById('student_name').value;
                const surname = document.getElementById('student_surname').value;
                const age = document.getElementById('student_age').value;
                const year = document.getElementById('student_year').value;
                const gender = document.getElementById('student_gender').value;

                // Create an object with the data
                const studentData = {
                    name: name,
                    surname: surname,
                    age: age,
                    year: year,
                    sex: gender,
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/student/save',
                    method: 'POST',
                    data: studentData,
                    success: function(response) {
                        console.log('Success:', response);
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });

            }

            document.getElementById('saveButton').addEventListener('click', saveStudentData);

            fetchLocations()
        });
    </script>
</head>

<body>

    <div class="container">
        <div class="row mx-5 mt-3">

            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-custom-purple" data-bs-toggle="modal"
                    data-bs-target="#addCounterDialog">เพิ่มนักเรียน</button>
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="row mx-5 mt-3">
            <table id="locationTable">
                <thead>
                    <tr class="tr-custom">
                        <th style="border-top-left-radius: 10px">ลำดับ</th>
                        <th>ชื่อ</th>
                        <th>สกุล</th>
                        <th>อายุ</th>
                        <th>รหัสชั้นปี</th>
                        <th>เพศ</th>
                        <th style="border-top-right-radius: 10px">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</body>


<div class="modal" id="addCounterDialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h2>เพิ่มนักเรียน</h2>
                </div>

                <div class="d-flex justify-content-center align-items-center" id="loadingSaveContainer"
                    style="display: none; height: 100%;">
                    <div class="spinner-grow text-dark" role="status" id="loadingSave">
                        <span class="visually-hidden">Saving</span>
                    </div>
                </div>

                <form id="counterForm">
                    <div class="mb-3">
                        <label for="student_name" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="student_name">

                        <label for="student_surname" class="form-label">สกุล</label>
                        <input type="text" class="form-control" id="student_surname">

                        <label for="student_age" class="form-label">อายุ</label>
                        <input type="text" class="form-control" id="student_age">

                        <label for="student_year" class="form-label">รหัสชั้นปี</label>
                        <input type="text" class="form-control" id="student_year">

                        <label for="student_gender" class="form-label">เพศ</label>
                        <input type="text" class="form-control" id="student_gender">

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary "
                                    data-bs-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-center">
                                <button type="button" class="btn btn btn-custom-purple" id="saveButton">บันทึก</button>
                            </div>
                        </div>

                    </div>


                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal" id="deleteCounterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h2>ลบข้อมูลหรือไม่</h2>
                </div>

                <div class="d-flex justify-content-center align-items-center" id="loadingDeleteContainer"
                    style="display: none; height: 100%;">
                    <div class="spinner-grow text-dark" role="status" id="loadingDelete">
                        <span class="visually-hidden">Saving</span>
                    </div>
                </div>


                <div class="deleteFormGroup">
                    <div class="text-center">
                        <span id="counterNameDisplay"></span>
                    </div>

                    <div class="row" id='button-group-sync'>
                        <div class="col-md-6">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary "
                                    data-bs-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <button type="button" class="btn btn btn-custom-purple"
                                    id="confirmDelete">บันทึก</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
</div>

<div class="modal" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h2>Error</h2>
                </div>

                <div class="text-center">
                    <h2>ลบข้อมูลไม่สำเร็จ</h2>
                </div>


                <div class="row" id='button-group-sync'>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>
