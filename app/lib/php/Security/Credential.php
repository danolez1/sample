<?php

namespace danolez\lib\Security\Credential;

abstract class Credential
{
     //Encoding::encode(KeyFactory::genCoke());
      const COKE = ("f9f8d28e9c93223ef9d2282643d9096cb409024bd1f1f82a6b2937a09c2aeee728d6d12101d6f2ef4435941f445dda028e9c0d93b4ee0a44930ac58e2d40faf2d93e264b63ee0663f617f2bceefaee40ee40");
   //Encoding::encode(KeyFactory::genSoda());
    const SODA = ("f9fa43eed24bfa80d2d2ef6cdaa0d9029c298ee5d20ac702fafa0a373e4b436bd9d9d22ad9805080faf8d63ea04b63ee3fd93e43a0281ebb1f434b0a21407deeeeeeee40ee40");
    const API_SODA = "da283fefd208eebc08a0d82208d8eeb328b38e43c528bb1ed60a63d9d2a0e7e72d6bd826f6431f6317081f50d280f68e80d9d63ed6ee436ba09b1e02ee40ee40";
    const CHUNK_SIZE = 4096;
    const NONCE = "nonce";
    const CIPHER = "cipher";
    const EIGHTBIT = ("8bit");
    const ENC_BLOCK_SIZE = 16;
}
