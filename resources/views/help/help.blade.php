@extends('master')

@section('seo_title')
    @if(!$page->seo_title)
        {{$page->name}}
    @else
        {{$page->seo_title}}
    @endif
@endsection
@section('meta_description')
    @if(!$page->meta_description)
        {{$page->excerpt}}
    @else
        {{$page->meta_description}}
    @endif
@endsection
@section('meta_keywords',$page->meta_keywords)

{{--blade占位函数--}}
@yield('content')

{{--循环内判断循环次数--}}
@if($loop->iteration%2 == 0)
    -- content --
@endif
{{--循环内判断循环次数 end--}}

{{--缩略图--}}
<img src="{{Voyager::image($post->thumbnail('small'))}}" />
{{--缩略图 end--}}

{{--前端跟踪js--}}
<head>
    <script>
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
            }
            return "";
        }
        function setCookie(c_name,value,expiredays)
        {
            var exdate=new Date()
            exdate.setDate(exdate.getDate()+expiredays)
            document.cookie=c_name+ "=" +escape(value)+
                ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/"
        }
        function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
        clientId = getCookie('clientId');
        if (!clientId){
            clientId = uuidv4();
        }
        setCookie('clientId',clientId,730);
        dataLayer = [{
            'clientId': clientId
        }];
    </script>


    @if(isset($related_products))
        <script>
            product_name = '{{$product->name}}';
            product_id = '{{$product->product_code}}';
            product_price = '{{$product->price}}';
            product_category = '{{$product->product_category_id}}';
        </script>
    @elseif(isset($products))
        <script>
            product_name = 'Category '+'{{$product_category->name}}';
            product_id = '{{$product_category->slug}}';
            product_price = '{{$products->avg('price')}}';
            product_category = '{{$product_category->name}}';
        </script>
    @elseif(isset($featured_products))
        <script>
            product_name = 'All';
            product_id = 'All';
            product_price = '{{$avg_price}}';
            product_category = 'All';
        </script>
    @else
        <script>
            product_name = 'All';
            product_id = 'All';
            product_price = '{{$avg_price}}';
            product_category = 'All';
        </script>
    @endif
<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-P7L2WXC');</script>
    <!-- End Google Tag Manager -->

    @yield('dataLayer_push')

    <title>@yield('seo_title') - {{title_case(setting('index.company_name'))}}</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
</head>
{{--前端跟踪js end--}}

{{--电子商务购买跟踪 - 点击链接--}}
<a href="https://api.whatsapp.com/send?phone={{setting('contact.phone')}}&text={{__('main.need_price')}}: @if(isset($related_products)){{$product->name}} @elseif(isset($products)){{$product_category->name}} @else All Products @endif" onclick="(function (){
                            dataLayer.push({
                                'event': 'productPurchase',
                                'ecommerce': {
                                'purchase': {
                                'actionField': {
                                'id': uuidv4(),
                                'affiliation': 'Header Whatsapp Click'
                            },
                            'products': [{
                                'name': product_name,
                                'id': product_id,
                                'price': product_price,
                                'category': product_category,
                                'quantity': 1
                                }]
                            }}
                            });
                            })()" class="header-icon header-icon-4"><i class="ion-social-whatsapp-outline"></i></a>
{{--电子商务购买跟踪 - 点击链接 end--}}

{{--电子商务，产品分类页浏览 + 产品单页浏览--}}
@section('dataLayer_push')
    <script>
        dataLayer.push({
            'ecommerce': {
                'impressions': [
                        @foreach($related_products as $related_product)
                    {
                        'name': '{{$related_product->name}}',
                        'id': '{{$related_product->product_code}}',
                        'price': '{{$related_product->price}}',
                        'category': '{{$related_product->product_category_id}}',
                        'list': 'Related Products',
                        'position': {{$loop->iteration}}
                    },
                    @endforeach
                ],
                'detail': {
                    'products': [{
                        'name': '{{$product->name}}',       // Name or ID is required.
                        'id': '{{$product->product_code}}',
                        'price': '{{$product->price}}',
                        'category': '{{$product->product_category_id}}'
                    }]
                }
            }});
    </script>
@endsection
{{--电子商务，产品分类页浏览 + 产品单页浏览 end--}}

{{--多级菜单实现并优化数据库查询--}}
{{--首先在AppServiceProvider中--}}
{{--view()->share('product_categories',ProductCategory::orderBy('order')->get());--}}
<ul>
    @foreach($product_categories->where('parent_id',null) as $product_category_1)
        <li class="mega-menu-container"><a href="/product_categories/{{$product_category_1->slug}}">{{$product_category_1->name}}</a>
                @foreach($product_categories->where('parent_id',$product_category_1->id) as $product_category_2)
                        <ul class="mega-menu-list clearfix">
                            @foreach($product_categories->where('parent_id',$product_category_2->id) as $product_category_3)
                                <li><a href="/product_category/{{$product_category_3->slug}}">{{title_case($product_category_3->name)}}</a></li>
                            @endforeach
                        </ul>
                @endforeach
        </li>
    @endforeach
</ul>
{{--多级菜单实现并优化数据库查询 end--}}

{{--多级菜单 面包屑--}}
<?php
$product_category = $product_categories->where('slug',$slug)->first();
$product_category_children = $product_categories->where('parent_id',$product_category->id);
$product_category_parent = null;
if ($product_category->parent_id){
    $product_category_parent = $product_categories->where('id',$product_category->parent_id)->first();
}
?>
{{--多级菜单 面包屑 end--}}

{{--多图的前端实现 - 这个添加了一些判断--}}
@if($product->image)
    @foreach(json_decode($product->image) as $product_image)
        <li @if($loop->first) class="active-slide" @endif><a data-rel='prettyPhoto[product]'
                                                             href="{{Voyager::image($product_image)}}"
                                                             data-image="{{Voyager::image($product_image)}}"
                                                             data-zoom-image="{{Voyager::image($product_image)}}"
                                                             class="product-gallery-item"><img
                        src="{{Voyager::image($product_image)}}" alt="{{$product->name}} 1"></a>
        </li>
    @endforeach
@endif
@if(count(json_decode($product->image))==2)
    ---
@elseif(count(json_decode($product->image))==3)
    ---
@endif
{{--多图的前端实现 - 这个添加了一些判断 end--}}

{{--第一张图与最后一张图--}}
<img src="{{ image_small(Voyager::image(head($images_path))) }}">
<img src="{{ image_small(Voyager::image(last($images_path))) }}">
{{--第一张图与最后一张图 end--}}

{{--联系我们--}}
{{csrf_field()}}
<input type="hidden" name="url" value="{{url()->current()}}">

<script>
    document.write('<input type="hidden" name="clientId" value=\"',clientId,'">');
</script>

{{--搜索框--}}
<form role="search" method="get" class="search-form" action="/search_result">
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="search" class="search-field form-control" placeholder="全站搜索…" value="" name="keyword">
            <button type="submit" class="btn btn-default"></button>
        </div>
    </div>
</form>