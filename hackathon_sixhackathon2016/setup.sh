

# setup file for nodes 01-05

for n in node0{1..5}
do
    echo "\nnode: $n"
    geth  \
    --genesis genesis.json      \
    --datadir   "data/$n"     \
    --networkid 55555           \
    --rpcport 8547              \
    --port 30302                \
    --maxpeers 5                \
    --rpc                       \
    --nat "any"                 \
    --ipcdisable                \
    js node_config.js

    echo "\n"
done
