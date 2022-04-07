clean:
	rm -rf data/rooms/*
	echo "[]" > data/rooms.json

chmod:
	chmod 666 data/rooms.json
	chmod 666 data/log.json