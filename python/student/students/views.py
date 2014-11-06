from django.shortcuts import get_object_or_404, render
from django.http import HttpResponseRedirect, HttpResponse
from django.core.urlresolvers import reverse
from django.views import generic

from students.models import Student

def index(request):
	if (request.method == "POST"):
		student_list = Student.objects.filter(name__startswith=request.POST['search'])
		context = {'student_list': student_list, 'search': request.POST['search']}
		return render(request, 'students/index.html', context)
		
	if ('sort' in request.GET):
		sort = request.GET['sort']
		order = request.GET['order']
		if sort == 'class':
			sort = 'student_class'
		if sort == 'dob':
			sort = 'date_of_birth'
		student_list = Student.objects.all().order_by('-'+sort)
		context = {'student_list': student_list, 'order': order}
		return render(request, 'students/index.html', context)
	order = 1
	student_list = Student.objects.all().order_by('id')
	context = {'student_list': student_list, 'order': order}
	return render(request, 'students/index.html', context)
	

class DetailView(generic.DetailView):
	model = Student
	template_name = 'students/detail.html'