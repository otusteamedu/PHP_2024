#!/bin/bash

sleep 10


node_1_ip=$(getent hosts redis-node-1 | awk '{ print $1 }')
node_2_ip=$(getent hosts redis-node-2 | awk '{ print $1 }')
node_3_ip=$(getent hosts redis-node-3 | awk '{ print $1 }')
node_4_ip=$(getent hosts redis-node-4 | awk '{ print $1 }')
node_5_ip=$(getent hosts redis-node-5 | awk '{ print $1 }')
node_6_ip=$(getent hosts redis-node-6 | awk '{ print $1 }')



redis-cli --cluster create $node_1_ip:6379 $node_2_ip:6379 $node_3_ip:6379 $node_4_ip:6379 $node_5_ip:6379 $node_6_ip:6379  --cluster-replicas 1 --cluster-yes