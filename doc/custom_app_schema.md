# Custom application schema

If custom GraphQL resources are needed, the schema generated from the eZ Platform repository can be customized.
To do so, create the `app/config/graphql/Query.types.yml` file, and define it as an object that inherits
from the `Domain` schema:

```yaml
# app/config/graphql/Query.types.yml
Query:
    type: object
    inherits:
        - Domain
    config:
        fields:
            customField:
                type: object
```

In that file, you can add new fields that use any custom type or custom logic you require, based
on [overblog/GraphQLBundle](https://github.com/overblog/GraphQLBundle).

## Custom mutations
The same way, you can create the `app/config/graphql/Mutation.types.yml` file to define custom mutations
Once mutations are implemented for the eZ Platform schema, your custom Mutation type will have to
be modified to extend it:

```yaml
Mutation:
    type: object
    inherits: [PlatformMutation]
    config:
        fields:
            createSomething:
                builder: Mutation
                builderConfig:
                        inputType: CreateSomethingInput
                        payloadType: SomethingPayload
                        mutateAndGetPayload: "@=mutation('CreateSomething', [value])"

CreateSomethingInput:
    type: relay-mutation-input
    config:
        fields:
            name:
                type: String

SomethingPayload:
    type: object
    config:
        fields:
            name:
                type: String

```