@extends('_layouts.mobile-layouts.index')

@section('content')
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between rtl-flex-d-row-r">
            <h6>Berita & Informasi</h6>
            <a href="{{ appSet('SCHOOL_WEBSITE') }}" class="btn btn-primary btn-sm">Selengkapnya</a>
        </div>
        <div class="row g-2" id="renderBlog">
            
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
                            && item._embedded['wp:featuredmedia'][0].media_details.sizes.medium_large) {
                            thumbUrl = item._embedded['wp:featuredmedia'][0]
                                        .media_details.sizes.medium_large.source_url;
                        }

                        blogHtml += `
                            <div class="col-12">
                                <div class="card blog-card list-card">
                                    <div class="post-img">
                                        <img src="${thumbUrl}" alt="${item.title.rendered}" style="max-height: 180px; object-fit: cover; width: 100%;" loading="lazy">
                                    </div>
                                    
                                    <div class="post-content">
                                        <a class="post-title" href="${item.link}" target="_blank">
                                            ${item.title.rendered}
                                        </a>
                                    </div>
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

