<template>
<div>
<section class="page_404 vh-100">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-sm-10 text-center">
					<div class="four_zero_four_bg">
						<h1 class="text-center ">{{status}}</h1>
					</div>

					<div class="contant_box_404">
						<h1>{{title}}</h1>

						<p>{{ description }}</p>
						 <a :href="$route('login')" class="link_404">Go back home</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
</template>

<script>
export default {
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: 'Service Unavailable',
                500: 'Server Error',
                404: 'Page Not Found',
                403: 'Forbidden',
            } [this.status]
        },
        description() {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon!',
                500: 'Whoops, something went wrong on our servers!',
                404: 'Sorry, the page you are looking for could not be found!',
                403: 'Sorry, you are forbidden from accessing this page!',
            } [this.status]
        },
    },
}
</script>
<style  lang="css" scoped>
      .page_404 {
            background: #fff;
            font-family: monospace;
        }

        .page_404 img {
            width: 100%;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }

        .four_zero_four_bg {
            background-image: url(https://www.nainzulinu.com/wp-content/uploads/2017/01/zabluda.jpg);
            height: 350px;
            background-position: center 70%;
            background-repeat: no-repeat;
            background-size: 200px;
        }

        .four_zero_four_bg h1 {
            font-size: 80px;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }
        .link_404 {
            color: #fff!important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }
        .link_404:hover{
            text-decoration: none;
        }
        .contant_box_404 {
            margin-top: -50px;
        }
        .h-100 {
            height: 100%!important;
        }
        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }
        .align-items-center {
            -ms-flex-align: center!important;
            align-items: center!important;
        }
        .justify-content-center {
            -ms-flex-pack: center!important;
            justify-content: center!important;
        }
        @media (min-width: 576px) {
            .col-sm-10 {
                -ms-flex: 0 0 83.333333%;
                flex: 0 0 83.333333%;
                max-width: 83.333333%;
            }
        }
        .text-center {
            text-align: center!important;
        }
</style>
