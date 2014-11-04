from django.contrib import admin
from polls.models import Question, Choice
class ChoiceInline(admin.TabularInline):
	model = Choice
	extra = 1
class QuestionAdmin(admin.ModelAdmin):
	fieldsets = [
	('Texts',               {'fields': ['question_text']}),
	('Date information', {'fields': ['pub_date'], 'classes': ['sss']}),
	]
	inlines = [ChoiceInline]
	list_display = ('question_text', 'pub_date', 'was_published_recently')
	list_filter = ['pub_date']
	search_fields = ['question_text']
	list_per_page = 10



admin.site.register(Question, QuestionAdmin)
