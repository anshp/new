class album:
	def __init__(self, title, artist):
		self.title = title
		self.artist = artist
x = []
for i in range(1, 21):
	x.append(album("album " + str(i), "artist " + str(i)))

for i in range(20):
	print(x[i].title,x[i].artist)