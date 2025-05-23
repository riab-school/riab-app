@extends('_layouts.mobile-layouts.index')

@section('title', 'Berita dan Informasi')

@section('content')
    <div class="container">
        <div class="row gy-3" id="renderBlog">
            
        </div>
    </div>   
@endsection

@push('scripts-mobile')
<script>
    let page = 1;
    let isLoading = false;
    let isLastPage = false;

    function loadMoreBlog() {
        if (isLoading || isLastPage) return;
        isLoading = true;

        $('#renderBlog').append(`<div class="text-center d-flex justify-content-center align-items-center py-5" id="loaders"><div class="loaders"></div></div>`);

        $.ajax({
            url: "{{ route('parent.berita.get') }}",
            type: 'GET',
            data: { page: page },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.blog.length > 0) {
                    let blogHtml = '';
                    $.each(res.blog, function(index, item) {
                        let thumbUrl = '{{ asset('mobile-assets') }}/img/bg-img/default.png';
                        if (item._embedded 
                            && item._embedded['wp:featuredmedia'] 
                            && item._embedded['wp:featuredmedia'][0] 
                            && item._embedded['wp:featuredmedia'][0].media_details 
                            && item._embedded['wp:featuredmedia'][0].media_details.sizes 
                            && item._embedded['wp:featuredmedia'][0].media_details.sizes["Blog Column Thumbnail"]) {
                            thumbUrl = item._embedded['wp:featuredmedia'][0].media_details.sizes["Blog Column Thumbnail"].source_url;
                        }

                        let authorName = '';
                        if (item._embedded 
                            && item._embedded['author'] 
                            && item._embedded['author'][0] 
                            && item._embedded['author'][0].name ) {
                            authorName = item._embedded['author'][0].name;
                        }
                        
                        blogHtml += `
                            <div class="col-12">
                                <div class="single-vendor-wrap bg-img p-4 bg-overlay" style="background-image: url('${thumbUrl}')">
                                    <h6 class="vendor-title text-white">${item.title.rendered}</h6>
                                    <div class="vendor-info">
                                        <p class="mb-1 text-white">
                                            ${authorName} | ${indoDateTime(item.date)}
                                        </p>                                    
                                    </div>
                                    <a class="btn btn-warning btn-sm mt-3" href="${item.link}" target="_blank">Baca Selengkapnya<i class="fa-solid fa-arrow-right-long ms-1"></i></a>
                                </div>
                            </div>
                        `;
                    });

                    $('#loaders').remove();
                    $('#renderBlog').append(blogHtml);
                    page = res.next_page;
                    if (!page) isLastPage = true;
                } else {
                    isLastPage = true;
                    $('#loaders').remove();
                    let noBlogHtml = `
                        <div class="horizontal-product-card">
                            <div class="d-flex align-items-center justify-content-center text-center py-5">
                                <h5>Tidak ada data</h5>
                            </div>
                        </div>
                    `;
                    $('#renderBlog').append(noBlogHtml);
                }
                isLoading = false;
            },
            error: function(xhr, status, error) {
                console.error(error);
                isLoading = false;
                $('#loaders').remove();
            }
        });
    }

    $(document).ready(function() {
        loadMoreBlog(); // initial load

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                loadMoreBlog();
            }
        });
    });
</script>
@endpush

