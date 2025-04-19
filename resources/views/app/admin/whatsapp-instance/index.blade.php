@extends('_layouts.app-layouts.index')

@push('styles')
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
@endpush

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>Connect To Whatsapp</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-md-center text-center">
                    <div class="col col-md-auto" id="qr" style="display:none;">
                        <div>
                            <p>Please scan this QR Code with Whatsapp in order to enable the API</p>
                        </div> 
                        <div id="qrContainer" class="text-center">

                        </div>
                    </div>
                    <div class="col col-md-auto">
                        <div id="connectstatus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Chat History</h5>
                <form action="{{ route('admin.whatsapp-intance.delete-history') }}" method="POST" onsubmit="return processData(this)">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete All</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-sm table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Phone</th>
                                <th>Name</th>
                                <th>Is Read</th>
                                <th>Response ID</th>
                                <th>Response Status</th>
                                <th>Response Message</th>
                                <th>Process Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url()->current() }}",
            drawCallback: function() {
                $('.pagination').addClass('pagination-sm');
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, row) {
                        switch(data){
                            case 'text':
                                return `<span class="badge badge-light-primary">Text</span>`;
                            case 'image':
                                return `<span class="badge badge-light-danger">Image</span>`;
                            case 'video':
                                return `<span class="badge badge-light-success">Video</span>`;
                            case 'audio':
                                return `<span class="badge badge-light-success">Audio</span>`;
                            case 'document':
                                return `<span class="badge badge-light-success">Document</span>`;
                            case NULL:
                                return ``;
                        }
                    }
                },
                {
                    data: 'category',
                    name: 'category',
                },
                {
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'is_read',
                    name: 'is_read',
                    render: function(data, type, row) {
                        switch(data){
                            case 1:
                                return `<span class="badge badge-light-primary">Readed</span>`;
                            case 0:
                                return `<span class="badge badge-light-danger">Unread</span>`;
                        }
                    }
                },
                {
                    data: 'response_id',
                    name: 'response_id',
                },
                {
                    data: 'response_status',
                    name: 'response_status',
                    render: function(data, type, row) {
                        switch(data){
                            case '1':
                                return `<span class="badge badge-light-success">Success</span>`;
                            case '0':
                                return `<span class="badge badge-light-danger">Failed</span>`;
                            case NULL:
                                return ``;
                        }
                    }
                },
                {
                    data: 'response_message',
                    name: 'response_message',
                },
                {
                    data: 'process_status',
                    name: 'process_status',
                    render: function(data, type, row) {
                        switch(data){
                            case 'pending':
                                return `<span class="badge badge-light-warning">Pending</span>`;
                            case 'success':
                                return `<span class="badge badge-light-success">Success</span>`;
                            case 'failed':
                                return `<span class="badge badge-light-danger">Failed</span>`;
                            case NULL:
                                return ``;
                        }
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                }
            ]
        });
    });

    // Starting
    let scanned = false;
    let scanInterval;

    async function wait(time) {
        return new Promise(resolve => {
            setTimeout(() => {
            resolve();
            }, time);
        });
    }

    function disconnectDevice() {
        console.log("disconnectDevice");
        fetch("{{ route('admin.whatsapp-intance.disconnect') }}", {
            method: "GET",
        }).then((res) => {
            if(res.ok) {
                document.getElementById("connectstatus").innerHTML = "Disconnected";
                scanned = false;
                showQr();
            }
        });
    }

    function checkStatus() {
        console.log("checkStatus");
        statusRequest().then((status) => {
            if(status.success==true) {
            if(status.data.LoggedIn === true) {
                scanned = true;
                document.getElementById("connectstatus").innerHTML = "<img src='{{ asset('assets/images/connected.png') }}' width='100px'/><br/><br/>" + "<h4>Connected !</h4><br/><br/><button class='btn btn-sm btn-outline-danger' onclick='disconnectDevice()'>Disconnect</button>";
                clearInterval(scanInterval);
                var imageParent = document.getElementById("qr");
                imageParent.style.display = "none";
            }
            } else {
            clearInterval(scanInterval);
            }
        });
    }

    async function showQr() {
        clearInterval(scanInterval);
        scanInterval = setInterval(checkStatus, 1000);
        console.log("showQr");
        while (!scanned) {
            console.log("not scanned");
            var qrData = await getQr();
            if(qrData.success==true) {
            var qrString = qrData.data.QRCode;
            var image = document.createElement("img");
            var imageParent = document.getElementById("qr");
            var imageContainer = document.getElementById("qrContainer");
            imageParent.style.display = "block";
            image.id = "qrcode";
            image.src = qrString;
            image.width = 200;
            imageContainer.innerHTML = "";
            imageContainer.appendChild(image);
            if(qrData.data.QRCode != "") {
                await wait(15 * 1000);
            }
            } else {
            scanned = true;
            clearInterval(scanInterval);
            document.getElementById("connectstatus").innerHTML = "Timeout! Please refresh the page when you are ready to scan the QR code";
            var imageParent = document.getElementById("qr");
            imageParent.style.display = "none";
            }
        }
    }

    async function connect() {
        console.log("Connecting...");
        res = await fetch("{{ route('admin.whatsapp-intance.connect') }}", {
            method: "GET",
        });
        data = await res.json();
        return data;
    }

    async function getQr() {
        res = await fetch("{{ route('admin.whatsapp-intance.getqr') }}", {
            method: "GET",
        });
        data = await res.json();
        return data;
    }

    async function statusRequest() {
        res = await fetch("{{ route('admin.whatsapp-intance.status') }}", {
            method: "GET",
        });
        data = await res.json();
        return data;
    }

    statusRequest().then((status) => {
        if(status.success==true) {
            if(status.data.LoggedIn === false) {
                if(status.data.Connected === true) {
                    showQr();
                } else {
                    console.log("Not connected, attempting to connect.");
                    connect().then((data) => {console.log("promise connect 1"); console.log(data);});
                }
            } else {
                if(status.data.Connected === false) {
                    connect().then((data) => {console.log("promise connect 2"); console.log(data);});
                }
                document.getElementById("connectstatus").innerHTML = "<img src='{{ asset('assets/images/connected.png') }}' width='100px'/><br/><br/>" + "<h4>Connected !</h4><br/><br/><button class='btn btn-sm btn-outline-danger' onclick='disconnectDevice()'>Disconnect</button>";
                scanned = true;
                var imageParent = document.getElementById("qr");
                imageParent.style.display = "none";
            }
        } else if(status.success==false) {
            if(status.error=="No session") {
                connect().then((data) => {
                    if(data.success==true) {
                        showQr();
                    } else {
                        document.getElementById("connectstatus").innerHTML = "Could not connect";
                    }
                });
            } else if(status.error=="Unauthorized") {
                document.getElementById("connectstatus").innerHTML = `Bad Authentication`;
            }
        } else {
            document.getElementById("connectstatus").innerHTML = `Bad Authentication ${status.Status}`;
        }
        return;
    });
</script>
@endpush