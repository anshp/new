from django.contrib import admin
from students.models import Student

class QuestionAdmin(admin.ModelAdmin):
	fieldsets = [
	('Student Information', {'fields': ['name', 'student_class', 'date_of_birth']}),
	]
	list_display = ('name', 'student_class', 'date_of_birth')
	list_filter = ['student_class']
	search_fields = ['name']

admin.site.register(Student, QuestionAdmin)