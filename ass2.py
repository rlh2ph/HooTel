#assignment 2. once you read the assignment pdf the code is self explanatory


class Bucket:
    # self expanding separate chaining hash resolution
    def __init__(self, size):
        self.stuff = [[]]
        self.size = size
        self.itr = 0

    def insert(self, item):
        if len(self.stuff[self.itr]) < self.size:
            self.stuff[self.itr].append(item)

        else:
            self.stuff.append([])
            self.itr += 1
            self.stuff[self.itr].append(item)

    def __str__(self):
        return str(self.stuff)

def hashf(size, item):
    ret = 0
    for i in item:
        if type(i) == str:
            ret += ord(i)
        else:
            ret += i

    return ret%size

def main():
    num = int(input("How many search keys? "))
    list = []
    for i in range(0, num):
        list.append(input("Input search key: "))
    num_buc = int(input("How many buckets? "))
    recq_buc = int(input("How many records per buckets? "))

    index = []
    for i in range(0, num_buc):
        index.append(Bucket(recq_buc))

    for item in list:
        ret = hashf(num_buc, item)
        index[ret].insert(item)

    for item in index: print(item)

if __name__ == "__main__":
    main()
