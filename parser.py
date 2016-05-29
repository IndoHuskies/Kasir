import csv, sys

MENU = {"beetle_cafe": ["Item 1",
						"Item 2",
						"Item 3",
						"Item 4"],
		"bumbu_truck": ["Ketoprak", 
						"Nasi Ayam Bakar, Tahu Bandung, Lalapan & Sambal Terasi", 
						"Martabak Telur", 
						"Soto Mie Jakarta", 
						"Es Kacang"],
		"depot_cemilan": ["Kusuka",
						  "Mie Kremes",
						  "Momogi Keju",
						  "Momogi Jagung Bakar",
						  "Tango Vanilla",
						  "Tango Chocolate",
						  "Tango Strawberry",
						  "Chitato Indomie",
						  "Assorted Yupi"],
		"depot_minuman": ["Bottled Water",
						  "Teh Botol",
						  "Teh Kotak",
						  "Milo",
						  "Yeo's chrysantehmun",
						  "Yeo's soymilk",
						  "Yeo's sugar cane",
						  "Yeo's water gourd",
						  "Kusuka",
						  "Mie Kremes",
						  "Momogi Keju",
						  "Momogi Jagung Bakar",
						  "Tango Vanilla",
						  "Tango Chocolate",
						  "Tango Strawberry",
						  "Chitato Indomie",
						  "Assorted Yupi"],
		"ifc_bellevue": ["Corn Cup",
						 "Bakwan Jagung",
						 "Bakwan Sayur",
						 "Martabak Mie",
						 "Sosis Gulung Mie"],
		"indo_cafe": ["Sate Ayam",
					  "Sate Babi",
					  "Lontong"],
		"isans": ["Es Buah",
				  "Es Mambo (2pcs)",
				  "Brownies Pisang Goreng Keju",
				  "Es Mambo (1pcs)",
				  "Roti Bakar"],
		"isasu": ["Nasi Bali",
				  "Kopyor Durian",
				  "Dorian",
				  "Salted Egg Chips"],
		"macaronnesia": ["Dadar Gulung",
						 "Coklat Kacang Wijen",
						 "Ube",
						 "Salted Caramel"],
		"malay_satay_hut": ["Nasi Lemak",
							"Hainase Chicken Rice",
							"Malaysian Fried Rice ($10.00)",
							"Malaysian Fried Rice Noodle",
							"Dry Curry Chicken Rice",
							"Shaved Ice",
							"Teh Tarik"],
		"martabak_holland": ["Martabak Manis Nutella",
							 "Martabak Manis Keju",
							 "Martabak Manis Skippy"],
		"rajawali": ["Jus Alpukat",
					 "Jagung Bakar",
					 "Roti Ice Cream"],
		"warjan": ["Bakso",
				   "Bubur",
				   "Siomay",
				   "Markisa",
				   "Es Cendol"],
		"warjan_ns": ["Nasi Padang"]
	}

def count_item(menu, entries):
	cnt = {}
	for k in menu:
		if k not in cnt:
			cnt[k] = 0
		for e in entries:
			item = e[1]
			comment = e[4]

			# exclude tester
			if "test" in comment:
				continue
			
			for i in item:
				q = i[0]
				x = i[1]
				if k in x:
					#print e[0], " - ", q, " ", x
					cnt[k] += q
	return cnt


def get_menu(fname):
	for k in MENU:
		if k in fname:
			return MENU[k]

def parse_item(txt):
	lst = []
	lines = txt.split("\\n")

	for l in lines:
		t = l.strip()
		idx = t.find("x")
		if t[0] == "'":
			q = int(l.strip()[1:idx])
		else:
			q = int(l.strip()[0:idx])
		item = l.strip()[(idx + 1):].strip()
		lst.append((q, item))
	return lst

def main():
	entries = []
	total = 0
	with open(sys.argv[1], "rb") as csvfile:
		reader = csv.reader(csvfile, delimiter=';')

		for r in reader:
			id_tr = int(r[0])
			item_tr = parse_item(r[1].strip())
			cash = float(r[2])
			time = r[3]
			comment = r[4].strip()
			entries.append((id_tr, item_tr, cash, time, comment))

			total += cash

	menu = get_menu(sys.argv[1])

	cnt = count_item(menu, entries)

	print "# of transactions: ", len(entries)
	print "Total sell: $", total

	print
	for c in cnt:
		print cnt[c], " ", c
	return

if __name__ == "__main__":
    main()