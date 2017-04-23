<div class="seo_block">
	<div class="col-md-12">

		<div class="row">

			<div class="col-md-4">
				<div class="form-group">
					<h4>SEO оптимизация</h4>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-md-4">
				<div class="form-group">
					{{ Form::label('seo_title', 'Заголовок окна страницы') }}
					{{ Form::text('seo_title', $model->seoText ? $model->seoText->title : '', ['class' => 'form-control']) }}
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					{{ Form::label('seo_keywords', 'Ключевые слова') }}
					{{ Form::text('seo_keywords', $model->seoText ? $model->seoText->keywords : '', ['class' => 'form-control']) }}
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					{{ Form::label('seo_description', 'Мета описание') }}
					{{ Form::text('seo_description', $model->seoText ? $model->seoText->description : '', ['class' => 'form-control']) }}
				</div>
			</div>

		</div>

		{{ Form::hidden('seo_block_enable', 1) }}

		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
