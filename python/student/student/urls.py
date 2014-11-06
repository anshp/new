from django.conf.urls import patterns, include, url
from django.contrib import admin

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'student.views.home', name='home'),
    # url(r'^blog/', include('blog.urls')),
    url(r'^students/', include('students.urls', namespace="students")),
    url(r'^admin/', include(admin.site.urls)),
)
