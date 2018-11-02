```
curl -v -X POST \
  http://localhost:8000/graphql \
  -H 'Cookie: eZSESSID98defd6ee70dfb1dea416cecdf391f58=cdkln1g0q8bhuc3mreu7nhaq3d' \
  -F 'operations={"query":"mutation CreateImage($name: String!, $alternativeText: String!, $file: ImageUpload!) { createImage( parentLocationId: 51, input: { name: $name, image: {alternativeText: $alternativeText, file: $file} } ) { _info { id mainLocationId } name image { fileName alternativeText uri } } }","variables":{"file": null, "name": "2nd image upload", "alternativeText": "With generated schema"}}' \
  -F 'map={"0":["variables.file"]}' \
  -F "0"=@/Users/bdunogier/Desktop/screenshot.png
```

See https://github.com/jaydenseric/graphql-multipart-request-spec#file-list for multiple files.
