require("gd")

math.randomseed(os.time())

function showStatus(done, total)
	if done > total then return end
	local disp = math.floor((done / total) * 100)
	io.write("\r" .. disp .. "%")
end

function getHeightFromPixel(map, x, y)
	local pixel = map:getPixel(x, y)
	local level = 255 - map:red(pixel)
	return math.floor(level / 4)
end

if table.maxn(arg) ~= 3 then
	print("Usage:")
	print("MapGenerator.lua <heightmap_file> <output_file.vxl> <scale_file>")
	os.exit(1)
end

if not io.open(arg[1], 'rb') then
	print("Error: Heightmap not found!")
	os.exit(3)
end
local map = gd.createFromPng(arg[1])

if not io.open(arg[3], 'rb') then
	print("Error: Heightscale not found!")
	os.exit(4)
end
local scale = gd.createFromPng(arg[3])

local f = io.open(arg[2], 'wb')
if not f then
	print("Error: Cannot create map file!")
	os.exit(5)
end

print("Generating...")

for j = 0, 511 do
	for i = 0, 511 do
		local gap = 0
		local adjHeights = {}
		local currHeight = getHeightFromPixel(map, i, j)
		local hmPixel = scale:getPixel(0, currHeight)
		local hmColor = { map:red(hmPixel), map:green(hmPixel), map:blue(hmPixel) }

		table.insert(adjHeights, getHeightFromPixel(map, (i - 1) % 512, j))
		table.insert(adjHeights, getHeightFromPixel(map, (i + 1) % 512, j))
		table.insert(adjHeights, getHeightFromPixel(map, i, (j - 1) % 512))
		table.insert(adjHeights, getHeightFromPixel(map, i, (j + 1) % 512))

		local shadow = (adjHeights[1] < currHeight) and 1 or 0

		for _, adjHeight in ipairs(adjHeights) do
			if adjHeight > currHeight + gap + 1 then
				gap = adjHeight - currHeight - 1
			end
		end

		f:write(string.char(0))
		f:write(string.char(currHeight))
		f:write(string.char(currHeight + gap))
		f:write(string.char(0))

		for k = 0, gap do
			f:write(string.char(hmColor[3] + math.random(-2, 2) - (16 * shadow)))
			f:write(string.char(hmColor[2] + math.random(-2, 2) - (16 * shadow)))
			f:write(string.char(hmColor[1] + math.random(-2, 2) - (16 * shadow)))
			f:write(string.char(128))
		end
	end

	showStatus((j + 1) * 512, 512 * 512)
end
