import sys

fname = sys.argv[1] + ".txt"
entry = sys.argv[2] + "\n"

with open(fname, 'a') as f:
    f.write(entry)
f.close()

print "success"