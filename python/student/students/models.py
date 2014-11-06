from django.db import models

class Student(models.Model):
	name = models.CharField(max_length=200)
	student_class = models.IntegerField("Class")
	date_of_birth = models.DateTimeField()
	def __unicode__(self):
		return self.name