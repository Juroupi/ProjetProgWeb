clean:
	rm -rf data/rooms/*.json
	rm -rf data/users/*.json
	echo "[]" > data/rooms.json
	echo "[]" > data/log.json

chmod:
	chmod 666 data/rooms.json
	chmod 666 data/log.json