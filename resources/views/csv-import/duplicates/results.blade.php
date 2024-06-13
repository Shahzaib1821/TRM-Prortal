@extends('layouts.app')
<style>
    .download-button {
        position: relative;
        border-width: 0;
        color: white;
        font-size: 15px;
        font-weight: 600;
        border-radius: 4px;
        z-index: 1;
    }

    .download-button .docs {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        min-height: 40px;
        padding: 0 10px;
        border-radius: 4px;
        z-index: 1;
        background-color: #242a35;
        border: solid 1px #e8e8e82d;
        transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .download-button:hover {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    }

    .download {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 90%;
        margin: 0 auto;
        z-index: -1;
        border-radius: 4px;
        transform: translateY(0%);
        background-color: #49bee2;
        border: solid 1px #01e0572d;
        transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        height: 38px;
        top: 1
    }

    .download-button:hover .download {
        transform: translateY(100%)
    }

    .download svg polyline,
    .download svg line {
        animation: docs 1s infinite;
    }

    @keyframes docs {
        0% {
            transform: translateY(0%);
        }

        50% {
            transform: translateY(-15%);
        }

        100% {
            transform: translateY(0%);
        }
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Scan Results</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Scanned Result</h4>
                            <a href="{{ route('scanForm') }}"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                <i class="bx bx-plus"></i> Scan More
                            </a>
                        </div>
                        <hr>

                        <table id="datatable" class="table table-bordered dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>File</th>
                                    <th>User</th>
                                    <th>Rows</th>
                                    <th>Good</th>
                                    <th>Bad</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $scan)
                                    <tr>
                                        <td>{{ $scan->id }}</td>
                                        <td>{{ $scan->FileName }}</td>
                                        <td>{{ $scan->User }}</td>
                                        <td>{{ $scan->TotalRows }}</td>
                                        <td>{{ $scan->Good }}</td>
                                        <td>{{ $scan->Bad }}</td>
                                        <td>{{ $scan->TimeSpammed }}</td>
                                        {{-- <td>{!! $scan->LastAction !!}<p><a href="{{ session('goodCsvLink') }}">Download Good CSV</a></p></td> --}}
                                        <td class="pb-4">
                                            {{-- {!! $scan->LastAction !!}
                                            <br> --}}
                                            @php
                                                $goodCsvLink = Storage::url(
                                                    'csvFilesFolder/good_' . $scan->FileName . '.gz',
                                                );
                                                $badCsvLink = Storage::url(
                                                    'csvFilesFolder/bad_' . $scan->FileName . '.gz',
                                                );
                                            @endphp
                                            <button class="download-button">
                                                <a href="{{ $goodCsvLink }}" download class="text-success">
                                                    <div class="docs"><svg class="css-i6dzq1" stroke-linejoin="round"
                                                            stroke-linecap="round" fill="none" stroke-width="2"
                                                            stroke="currentColor" height="20" width="20"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                            </path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line y2="13" x2="8" y1="13"
                                                                x1="16">
                                                            </line>
                                                            <line y2="17" x2="8" y1="17"
                                                                x1="16">
                                                            </line>
                                                            <polyline points="10 9 9 9 8 9"></polyline>
                                                        </svg>
                                                        <a href="{{ $goodCsvLink }}" download class="text-white">Good CSV
                                                        </a>
                                                    </div>
                                                    {{-- <div class="download">
                                                        <svg class="css-i6dzq1" stroke-linejoin="round"
                                                            stroke-linecap="round" fill="none" stroke-width="2"
                                                            stroke="currentColor" height="24" width="24"
                                                            viewBox="0 0 24 24">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line y2="3" x2="12" y1="15"
                                                                x1="12">
                                                            </line>
                                                        </svg>
                                                    </div> --}}
                                                </a>
                                            </button>
                                            <button class="download-button">
                                                <a href="{{ $badCsvLink }}" download class="text-warning">
                                                    <div class="docs">
                                                        <svg class="css-i6dzq1" stroke-linejoin="round"
                                                            stroke-linecap="round" fill="none" stroke-width="2"
                                                            stroke="currentColor" height="20" width="20"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                            </path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                            <line y2="13" x2="8" y1="13"
                                                                x1="16">
                                                            </line>
                                                            <line y2="17" x2="8" y1="17"
                                                                x1="16">
                                                            </line>
                                                            <polyline points="10 9 9 9 8 9"></polyline>
                                                        </svg> <a href="{{ $badCsvLink }}" download
                                                            class="text-white">Bad
                                                            CSV </a>
                                                    </div>
                                                    {{-- <div class="download">
                                                        <svg class="css-i6dzq1" stroke-linejoin="round"
                                                            stroke-linecap="round" fill="none" stroke-width="2"
                                                            stroke="currentColor" height="24" width="24"
                                                            viewBox="0 0 24 24">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line y2="3" x2="12" y1="15"
                                                                x1="12">
                                                            </line>
                                                        </svg>
                                                    </div> --}}
                                                </a>
                                            </button>
                                            {{-- Good CSV: <a href="{{ $goodCsvLink }}" download>Download </a><br> --}}
                                            {{-- Bad CSV: <a href="{{ $badCsvLink }}" download>Download </a> --}}
                                            <br>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
