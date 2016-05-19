import sys

fname = sys.argv[0] + ".txt"
entry = sys.argv[1] + "\n"

with open(fname, "a") as f:
    f.write(entry)
f.close()

print "success"