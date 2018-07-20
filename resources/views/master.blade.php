{{--master--}}
@if(isset($related_products))
    <script>
        product_price = '{{$product->price}}';
    </script>
@elseif(isset($category_products))
    <script>
        product_price = '{{$category_products->avg('price')}}';
    </script>
@elseif(isset($featured_products))
    <script>
        product_price = '{{$avg_price}}';
    </script>
@else
    <script>
        product_price = '{{$avg_price}}';
    </script>
@endif
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
        'clientId': clientId,
        'price':product_price
    }];
</script>

{{--联系我们--}}
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{csrf_field()}}
<input type="hidden" name="url" value="{{url()->current()}}">

<script>
    document.write('<input type="hidden" name="clientId" value=\"',clientId,'">');
</script>