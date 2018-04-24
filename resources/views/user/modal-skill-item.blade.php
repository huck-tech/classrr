<div class="shop-item col-lg-4 col-md-6 col-sm-6 col-xs-6" v-for="(item, index) in suggestionSkills" :key="item.id">
	<div class="inner-box inner-box-skill">		
		<div class="product_description">			
		<h6>@{{ item.name }}</h6>		
		<div class="progress">
			<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="gainPoint(item)"
			aria-valuemin="0" :aria-valuemax="item.max_level" :style="progressPoint(item)">	
			<span> @{{ sumPoint(item) }} of @{{ item.max_level }}</span>
		</div>
		</div>
		<div class="price" v-show="! hasReachMax(item)">
			<button class="btn btn-xs btn-danger" @click="reducePoint(item)" v-show="showMinusSign(item)">-</button>
			<button class="btn btn-xs btn-info" @click="addPoint(item)">+</button>
		</div>
		</div>
	</div>
</div>
<div :class="showLoadMore"><button class="btn_1 green btn-xs" @click="loadMore()">more +</button></div>