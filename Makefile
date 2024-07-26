# Default target: dist
default: dist

# Get amount of cores
CORES := $(shell grep -c ^processor /proc/cpuinfo)

mkdirs:
	mkdir -pv build
	mkdir -pv dist
	mkdir -pv bin

clean:
	rm -rfv build
	rm -rfv dist
	rm -rfv bin

build: mkdirs
	nuitka3 --follow-imports --static-libpython=no --output-dir=build --output-filename=bin/hcloud-ip --show-progress --jobs=$(CORES) hcloud-ip.py

dist: build
	cp -v bin/hcloud-ip dist/hcloud-ip
	chmod -v +x dist/hcloud-ip
	cp hcloud-ip.toml dist/hcloud-ip.toml